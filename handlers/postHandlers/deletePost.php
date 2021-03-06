<?php
session_start();
	require_once('../../QOB/qob.php');
	require_once('../fetch.php');
/*//Testing inputs
	$userIdHash=$_SESSION['vj']=hash("sha512","COE12B017".SALT);
	$_SESSION['tn']=hash("sha512",$userIdHash.SALT2);
	$_POST['_postId']="8122b703cb14aa7fe4370e91dc2757ebd3dc7ace4be8a20642ef42e9f362d10ed57f29cfba40975fa15457fcf2fbab764bb19fb8e9f92e8cab7fa04a19fa47a5";
	//$_POST['_postId']="16462edf7108a40bc1639284722e6c662964c1d527ce89113d63264cc20841c0f297f6d1044894d581e3196b3d9ca89eb201f469edde1f5e2ae62a8e95b107e1";
//Tessting Inputs End

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

	$conn= new QoB();
	$userIdHash=$_SESSION['vj'];
	//Checking the session varianles. Second Level Protection
	if(hash("sha512",$userIdHash.SALT2)!=$_SESSION['tn'])
	{
		// echo "Suspicious session variable in DeletePost".$userIdHash;
		if(blockUserByHash($userIdHash,"Suspicious Session Variable in editPost")>0)
		{
			$_SESSION=array();
			session_destroy();
			echo 14;
			exit();
		}
		else
		{
			notifyAdmin("Suspicious Session Variable in editPost",$userIdHash.",sh:".$_SESSION['tn']);
			$_SESSION=array();
			session_destroy();
			echo 13;
			exit();
		}
	}
	else
	{
		//Checking if the user Exists with the given hash! Third Level protection!!
		if(($user=getUserFromHash($userIdHash))==false)
		{
			// echo "Critical Error!! in DeletePost!!".$userIdHash;
			notifyAdmin("Critical Error!! in DeletePost!!",$userIdHash);
			$_SESSION=array();
			session_destroy();
			echo 13;
		}
		else
		{

			$postIdHash=$_POST['_postId'];
			if(($post=getPostFromHash($postIdHash))==false)
			{
				notifyAdmin("Suspicious pollIdHash in DeletePost",$userId.",sh:".$postIdHash);
				echo 5;
				exit();
			}
			else
			{
				$postUserId=$post['userId'];
				$postId=$post['postId'];
				$userId=$user['userId'];
				//$commentTableName="p".$postId."c";
				$commentTableName = "postcomments";
				if($postUserId==$userId)
				{
					$conn->startTransaction();
					$UpdatePostSQL="DELETE FROM post WHERE postIdHash= ?";
					$values[]=array($postIdHash => 's');
					$result=$conn->update($UpdatePostSQL,$values,true);
					if($conn->error=="")
					{
						if($result>0)
						{
							$DropCommentsFromTableSQL="DELETE FROM postcomments WHERE postId= ?";
							$values[0]=array($postId => 's');
							$res=$conn->update($DropCommentsFromTableSQL,$values);
							if($conn->error==""&&$res==true)
							{
								$postId=$post['postId'];
								$deletePostNotifSQL="DELETE FROM notifications WHERE objectId= ? AND objectType=500";
								$values1[0]=array($postId => 's');
								$result=$conn->delete($deletePostNotifSQL,$values1);
								if($conn->error=="")
								{
									echo 3;
									$conn->completeTransaction();
								}
								else
								{
									$cr=$conn->error;
									$conn->rollbackTransaction();
									notifyAdmin("Conn. Error :".$cr." while deleting notifications in delete post.", $postUserId);
									echo 12;
									exit();
								}
							}
							else
							{
								
								$cr=$conn->error;
								// echo $cr." For Drop Table In Delete Post".$postId.$userId;
								$conn->rollbackTransaction();
								notifyAdmin("Conn.Error: ".$cr." For Drop Table In Delete Post".$postId,$userId);
								echo 12;
							}
						}
						else
						{
							$conn->rollbackTransaction();
							echo 5;
							exit();
						}
						
						
					}
					else
					{
						// echo $cr." For Deleting Post".$postId,$userId;
						$cr=$conn->error;
						$conn->rollbackTransaction();
						notifyAdmin("Conn.Error: ".$cr." For Deleting Post".$postId,$userId);
						echo 12;
					}
				}
				else
				{
					// echo "Illegal Delete Attempt in DeletePost: ".$postIdHash;
					blockUserByHash($userId,"Illegal Delete Attempt in DeletePost: ".$postIdHash);
					$_SESSION=array();
					session_destroy();
					echo 13;
				}
			}
		}
	}

?>