<?php
/*
 *
 *TEMPLATE FOR Database CLASS. EDIT APPROPRIATELY AND RENAME TO "Database.php" 
 *
 */
 
require_once( 'Util.php' );

abstract class DatabaseConnection extends mysqli
{
	// const USER     = getenv('OPENSHIFT_MYSQL_DB_USERNAME');
	// const PASSWORD = getenv('OPENSHIFT_MYSQL_DB_PASSWORD');
	const DATABASE = 'cyclelive';
	// const PORT = getenv('OPENSHIFT_MYSQL_DB_PORT');

	public function __construct( $host, $user, $password, $database, $port )
	{
		parent::__construct( $host, $user, $password, $database, $port );

		if ( mysqli_connect_error() )
			throw new DatabaseConnectionException();
	}

	public function query( $query )
	{
		if ( !($result = parent::query( $query ) ) )
			Util::log( __METHOD__ . "() ERROR {$this->errno}: {$this->error}: \"{$query}\"" );
		
		return $result;
	}
}

class LocalDatabaseConnection extends DatabaseConnection 
{
	//const HOST     = getenv('OPENSHIFT_MYSQL_DB_HOST');

	public function __construct()
	{
		$host = 'cycle.c0pz9rduf4ic.us-east-1.rds.amazonaws.com';//173.194.251.23' ;
		$port = '3306';
		$user = 'cycleUser' ;
		$pass = 'Ph1lly123';
		parent::__construct( $host, $user, $pass, self::DATABASE, $port );
	}
}

class DatabaseConnectionFactory 
{
	static protected $connection = null;

	public static function getConnection()
	{
		if ( self::$connection )
			return self::$connection;
		else
			return self::$connection = new LocalDatabaseConnection();
	}
}

class DatabaseException extends Exception
{
	public function __construct( $message, $code )
	{
		parent::__construct( $message, $code );
	}
}

class DatabaseConnectionException extends DatabaseException
{
	public function __construct( $message=null, $code=null )
	{
		if ( !$message )
			mysqli_connect_error();

		if ( !$code )
			mysqli_connect_errno();

		parent::__construct( mysqli_connect_error(), mysqli_connect_errno() );
	}
}

