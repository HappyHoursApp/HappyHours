<?php
	/**
	* Provides a PDO style connection to the Database
	*
	* PHP Version 7
	*
	* @author     Jacob Laqua <jlaqua@mail.greenriver.edu>
	* @author     Mackenzie Larson <mlarson28@mail.greenriver.edu>
	* @author     Michael Peterson <mpeterson47@mail.greenriver.edu>
	*/
     
    /**
     * Establish a connection with the database
     *
     * @access public
     * @param string $dsn The name of the local db. 
     * @param string $username The username of the db user
     * @param string $password The password for the user on the db
     */
	function getConnection()
	{
		$dsn = 'mysql:host=localhost;dbname=techies_db'; // change this
		$username = 'techies_database'; // change this
		$password = 'lNki_L-Sk]~X'; // change this 
		
		try {
			$connection = new PDO($dsn, $username, $password);
			
			//Throw and exception if pdo has trouble connecting
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $connection;
		} catch (PDOException $ex) {
			echo 'Exception connecting to DB: ' . $ex->getMessage();
			exit();
		}
	}
?>