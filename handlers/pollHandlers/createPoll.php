<?php

//------Credits------//
//
//
//---Author : Hari Krishna Majety ,COE12B013.
//---Email: majetyhk@gmail.com
//
//
//---Credits Ends---//

session_start();	
require_once('../../QOB/qob.php');
require_once('./miniPoll.php');
require_once('../fetch.php');
//Testing Content Starts
	/*$userIdHash=$_SESSION['vj']=hash("sha512","EDM12B006".SALT);
	$_SESSION['tn']=hash("sha512",$userIdHash.SALT2);

	$_POST['_pollQuestion']="This is poll 4?";
	$_POST['_pollType']=1;
	$_POST['_pollOptions']=['4opt1','4opt2', '4opt3','4opt4'];
	$_POST['_pollOptionType']=1; //1 for single answer , 2 for multiple answers
	$_POST['_sharedWith']="MDM,COE";*/
//Testing Content Ends


/*
Code 3: SUCCESS!!
Code 5: Attempt to redo a already done task!
Code 6: Content Unavailable!
Code 13: SECURITY ALERT!! SUSPICIOUS BEHAVIOUR!!
Code 12: Database ERROR!!
code 14: Suspicious Behaviour and Blocked!
Code 16: Erroneous Entry By USER!!
Code 11: Session Variables unset!!

*/

if(!(isset($_SESSION['vj'])&&isset($_SESSION['tn'])))
{
	echo 11;
	exit();
}


//Actual CreatePoll Code Starts
$pollQuestion=$_POST['_pollQuestion'];
$pollType=$_POST['_pollType'];
$pollOptionsArray=$_POST['_pollOptions'];
$pollOptionsType=$_POST['_pollOptionType'];
$rawSharedWith=$_POST['_sharedWith'];

$pollOptionsCount=count($pollOptionsArray);

if($pollQuestion==""||$pollOptionsCount<=1)
{
	echo 16;
	exit();
}

for($i=0;$i<$pollOptionsCount;$i++)
{
	if(strlen($pollOptionsArray[$i])>36)
	{
		echo 16;// Longer options cause distortion in result charts in front-end. I know 36 is way too less but cant help.
		exit();
	}
}

if($pollType!=1&&$pollType!=2&&$pollType!=3)
{
	echo 16;
	exit();
}
if($pollOptionsType!=1&&$pollOptionsType!=2)
{
	echo 16;
	exit();
}
if($rawSharedWith=="")
{
	echo 16;
	exit();
}
$conn= new QoB();
$userIdHash=$_SESSION['vj'];
if(hash("sha512",$userIdHash.SALT2)!=$_SESSION['tn'])
{
	if(blockUserByHash($userIdHash,"Suspicious Session Variable in createPoll")>0)
	{
		$_SESSION=array();
		session_destroy();
		echo 14;
		exit();
	}
	else
	{
		notifyAdmin("Suspicious Session Variable in createPoll",$userIdHash.",sh:".$_SESSION['tn']);
		$_SESSION=array();
		session_destroy();
		echo 13;
		exit();
	}
}
else
{
	if(($user=getUserFromHash($userIdHash))==false)
	{
		notifyAdmin("Critical Error In createPoll",$userIdHash);
		$_SESSION=array();
		session_destroy();
		echo 13;
		exit();
	}
	else
	{
		$userId=$user['userId'];
		$splitSharedWith=explode(",", $rawSharedWith);
		$userName=$user['name'];
		$n=count($splitSharedWith);
		$sharedWith="";
		if(stripos($rawSharedWith,"All")===false)
		{
			if($rawSharedWith!=",")
			{
				for($i=0;$i<$n;$i++)
				{
					if($splitSharedWith[$i]!="")
					{
						//echo $i.",".$splitSharedWith[$i]."<br/>";
						$out=newValidateSharedWith($splitSharedWith[$i]);
						if($out=="Invalid")
						{
							echo 16;
							exit();
						}
						else
						{
							//echo $out;
							if($sharedWith=="")
							{
								$sharedWith=$out;
							}
							else
							{
								$sharedWith=$sharedWith.",".$out;
							}
						}
					}
				}//2
			}
			else
			{
				echo 16;
				exit();
			}	
		}
		else
		{
			$sharedWith="All";
		}
		$pollOptions=implode(',',$pollOptionsArray);
		

		$FetchMaxPollIDSQL="SELECT MAX(pollId) as maxPollId FROM poll";
		$maxPollID=$conn->fetchALL($FetchMaxPollIDSQL,false);
		if($conn->error!=""||$maxPollID=="")
		{
			notifyAdmin("Conn.Error.:".$conn->error."!In create Poll!!",$userId);
			echo 12;
			exit();
		}
		$eId=$maxPollID['maxPollId'];
		
		if($eId==NULL)
		{
			$pollId=1;
		}
		else
		{
			$pollId=$eId+1;
		}
		for($i=0;$i<$pollOptionsCount;$i++)
			$optionVotesArray[]=0;
		$optionVotes=implode(',',$optionVotesArray);
		$timestamp=time();
		$pollIdHash=hash("sha224", $pollId.POLLHASH);
		
		$isSAC=isSAC($userId);
		if($isSAC==1)
		{
			$createPollSQL="INSERT INTO poll (pollId,pollIdHash,pollType,question,options, optionsType,optionCount,sharedWith,userId,optionVotes,timestamp,approvalStatus) 
			VALUES(?,?,?,?,?,  ?,?,?,?,?, ?,1)";
		}
		else
		{
			$createPollSQL="INSERT INTO poll (pollId,pollIdHash,pollType,question,options, optionsType,optionCount,sharedWith,userId,optionVotes,timestamp) 
			VALUES(?,?,?,?,?,  ?,?,?,?,?, ?)";
		}
		//$createPollSQL="INSERT INTO poll set pollId=?,pollIdHash=?,pollType=?,question,options, optionsType,optionCount,sharedWith,$userId,optionVotes"
		$values[0]=array($pollId => 'i');
		$values[1]=array($pollIdHash => 's');
		$values[2]=array($pollType => 's');
		$values[3]=array($pollQuestion => 's');
		$values[4]=array($pollOptions => 's');
		$values[5]=array($pollOptionsType => 's');
		$values[6]=array($pollOptionsCount => 'i');
		$values[7]=array($sharedWith => 's');
		$values[8]=array($userId => 's');
		$values[9]=array($optionVotes => 's');
		$values[10]=array($timestamp => 's');
		//$values[11]=array($approvalStatus => 'i');
		$result=$conn->insert($createPollSQL,$values);
		if($conn->error==""&&$result==true)
		{
			//Success
			// $approvalStatus=1;
			if($isSAC!=1)
			{	
				$approvalStatus=0;
				sendNotification($userId,SAC,16,$pollId,700);
			}
			else
			{
				$approvalStatus=1;
			}	
			$ts = new DateTime();
			$ts->setTimestamp($timestamp);
			$pollCreationTime=$ts->format(DateTime::ISO8601);
			$hasVoted=0;
			$pollStatus=0;
			for($i=0;$i<$pollOptionsCount;$i++)
			{
				$optionsAndVotes[$i]=array($pollOptionsArray[$i] , (int)$optionVotesArray[$i]);
			}
			/*$proPicLocation='../../img/proPics/'.$userIdHash.'.jpg';
			if(file_exists($proPicLocation))
			{
				$proPicExists=1;
			}
			else
			{
				$proPicExists=-1;
			}*/
			$isSAC=isSAC($userId);
			$pollObj=new miniPoll($pollIdHash,$pollQuestion,$pollType,$pollOptionsArray,$pollOptionsType,
					$sharedWith,$hasVoted,json_encode($optionsAndVotes),$pollCreationTime,$pollStatus,1,$isSAC,$approvalStatus);
			print_r(json_encode($pollObj));
		}
		else
		{
			notifyAdmin("Conn.Error".$conn->error."! While inserting in create Poll",$userId);
			echo 12;
			exit();
		}
	}
}
?>