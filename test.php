<?php 
ob_start();
session_start();
define("DB_HOST", "localhost");
define("DB_NAME", "ohi_telecom");// Change your database name
define("DB_USER", "root");// Your database user id 
define("DB_PASS", "");   // Your password
define("TABLEPREFIX", "ohi_"); # Mysql Database Table Prefix

//folder paths
define('HOST','http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}");
define('CUR_URL',HOST. $_SERVER['REQUEST_URI']); //directory
define('DIR_PATH',HOST. dirname($_SERVER['REQUEST_URI'])); //directory
define('DIR_ADMIN', 'dashboard/ohi/admin/'); // absolute path for admin
define('DIR_UPLOADS', '/ohi_tele/dashboard/ohi/admin/uploads/'); // absolute path for admin
define('DIR_PDT_IMAGES', '/ohi_tele/dashboard/ohi/admin/uploads/products/'); // absolute path for admin
define('HTTP_SERVER',HOST.'/ohi_tele'); // eg, HOST or - http://localhost, should not be NULL for productive servers
define('ADMIN_EMAIL','techsofttest@gmail.com');//should change to user mail id

$home	=	"";
$about	=	"";
//Database Connection
try
{
     $DB_con = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASS);//(host;dbname,dbuser,dbpass)
     $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	 $DB_con->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);//to avoid quote numeric arguments
	 $DB_con->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, TRUE);

}
catch(PDOException $exception)
{
     die('Database Connection Failed: ' . $exception->getMessage());
}


class Techsoft
{
	private $dbh;
    private $error;
	
	
 //Database Connection
   public function __construct($DB_con)
     {
         $this->dbh = $DB_con;
     }
	//function to select values from a table
    public function select_rows($table,$fieldlist,$condition,$data)
	{		
	$stmt = $this->dbh->prepare("SELECT $fieldlist FROM $table $condition");
	$stmt->execute($data);
	//$stmt->debugDumpParams();	
	return $stmt;
	}//end function
	
	//function to insert values in a table
	public function insert_fields($table,$fieldlist,$values,$data)
	{	
		$stmt = $this->dbh->prepare("INSERT into $table ($fieldlist) values($values)");
		$stmt->execute($data);
		return $stmt;
	}//end function	

	//function to update values in a table
	public function update_rows($table,$fieldlist,$condition,$data)
	{
		$stmt = $this->dbh->prepare("UPDATE $table set $fieldlist $condition");
		$stmt->execute($data);
		return $stmt;
	}//end function
	
	//function for deleting values from table
	public function delete_rows($table,$condition,$data)
	{
		$stmt = $this->dbh->prepare("DELETE FROM $table $condition");
		$stmt->execute($data);
		return $stmt;
	}

}//end class
$objA		= 	new Techsoft($DB_con);
$sessionId	=	session_id();

	$cond_select_news	=	"ORDER BY NEWS_ID DESC LIMIT ?,?";
	$data_select_news 	= 	array(0,3);
	$pass_select_news	=	$objA->select_rows(TABLEPREFIX.'news','*',$cond_select_news,$data_select_news);
	
	if($pass_select_news->rowCount()>0)
		{
			while($arr_news = $pass_select_news->fetch(PDO::FETCH_ASSOC))	
			{
				echo $arr_news['NEWS_TITLE']."<br>";
			}
		}
		else
		{
			echo "No records found!";
		}

?>