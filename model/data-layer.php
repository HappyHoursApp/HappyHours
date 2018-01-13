<?php
/**
 * This file handles db interactions
 *
 * This file is used for interections with the db.
 * Whether it be inserting, updating or deleting this file will handle
 * final data validation on the back-end and data-massaging prior to
 * returning to the controller
 *
 * PHP version 7
 *
 * LICENSE: Infomation here.
 *
 * @author     Jacob Laqua <jlaqua@mail.greenriver.edu>
 * @author     Mackenzie Larson <mlarson28@mail.greenriver.edu>
 * @author     Michael Peterson <mpeterson47@mail.greenriver.edu>
 * @version    1.0 GitHub: <https://github.com/HappyHoursApp/HappyHours>
 * @link       fill later
 */

    require_once('db/connection.php');
    require_once('db/password.php');
	/**
	* This class creates a DataLayer object
	*
	* @author     Jacob Laqua <jlaqua@mail.greenriver.edu>
	* @author     Mackenzie Larson <mlarson28@mail.greenriver.edu>
	* @author     Michael Peterson <mpeterson47@mail.greenriver.edu>
	* @version    @version Release: 1.0
	*/
    class DataLayer
    {
        private $_pdo; //pdo object

        /**
         * Creates a new PDO object
         *
         * @access public
         * The PDO object has the connection to the db
         */
        public function __construct()
        {
            $this->_pdo = getConnection();
        }

        /* methods */
        
        /**
         * Method for adding a user to the DB
         *
         * This method performs back end validation and performs
         * the query to add a user to the DB who has properly filled
         * out the signup form
         *
         * @access public
         * @param  mixed  $data     The post data being passed from the controller
         * @return array  $data     An assoc array of the information the user entered originally
         * @return array  $errors   The errors found during validation
         */
        public function logUser($data)
        {
            
            $errors = array();
              //first name
              if (empty($data['fname'])) {
                  $errors[] = 'Please enter a first name';
              } elseif (strlen($data['fname']) > 50) {
                  $errors[] = 'First name must be less than 50 letters';
              } else {
                  $fname = $data['fname'];
              }
            
              //last name
              if (empty($data['lname'])) {
                  $errors[] = 'Please enter a last name';
              } elseif (strlen($data['lname']) > 50) {
                  $errors[] = 'Last name must be less than 50 letters';
              } else {
                  $lname = $data['lname'];
              }
            
              //school email
              if (empty($data['school_email']) || !filter_var($data['school_email'], FILTER_VALIDATE_EMAIL)) {
                  $errors[] = 'Please enter a valid school email';
              } else {
                  $school_email = $data['school_email'];
              }
            
              //primary email
              if (empty($data['prime_email']) || !filter_var($data['prime_email'], FILTER_VALIDATE_EMAIL)) {
                  $errors[] = 'Please enter a valid primary email';
              } else {
                  $prime_email = $data['prime_email'];
              }
            
              //bio
              if (empty($data['bio']) || strlen($data['bio']) > 1000) {
                  $errors[] = 'There is something wrong with your bio';
              } else {
                  $bio = $data['bio'];
              }
            
              //veteran
              if (!isset($data['veteran'])) {
                  $errors[] = 'You have not selected your veteran status';
              } else {
                  $veteran = $data['veteran'];
              }
            
              //degree
              if (!isset($data['degree'])) {
                  $errors[] = 'You have not selected your degree';
              } else {
                  $degree = $data['degree'];
              }
                     
              //technologies
              if (!isset($data['technologies'])) {
                  $errors[] = 'You have not selected your technologies';
              } else {
                  $technologies = $data['technologies'];
                  $technologies = implode(", ", $technologies);
                  $data['technologies'] = $technologies; // show a string on confirmation page
              }              
            if (sizeof($errors) == 0) {
                $insert = 'INSERT INTO profiles (fname, lname, school_email, prime_email, bio, veteran, twitter, linkedin, facebook, portfolio, github, degree, graduation, technologies)
                           VALUES (:fname, :lname, :school_email, :prime_email, :bio, :veteren, :twitter, :linkedin, :facebook, :portfolio, :github, :degree, :graduation, :technologies)';
      
                $statement = $this->_pdo->prepare($insert);
                $statement->bindValue(':fname', $fname, PDO::PARAM_STR);
                $statement->bindValue(':lname', $lname, PDO::PARAM_STR);
                $statement->bindValue(':school_email', $school_email, PDO::PARAM_STR);
                $statement->bindValue(':prime_email', $prime_email, PDO::PARAM_STR);
                $statement->bindValue(':bio', $bio, PDO::PARAM_STR);
                $statement->bindValue(':veteren', $veteran, PDO::PARAM_STR);
                $statement->bindValue(':twitter', $data['twitter'], PDO::PARAM_STR);
                $statement->bindValue(':linkedin', $data['linkedin'], PDO::PARAM_STR);
                $statement->bindValue(':facebook', $data['facebook'], PDO::PARAM_STR);
                $statement->bindValue(':portfolio', $data['portfolio'], PDO::PARAM_STR);
                $statement->bindValue(':github', $data['github'], PDO::PARAM_STR);
                $statement->bindValue(':degree', $degree, PDO::PARAM_STR);
                $statement->bindValue(':graduation', $data['graduation'], PDO::PARAM_INT);
                $statement->bindValue(':technologies', $technologies, PDO::PARAM_STR);
      
                $statement->execute();
                
                return $data;   
            } else {
                return $errors;
            }
        }

        /**
        * Method verifying that a user exists and that the password matches
        *
        * Note that this is a recycled method from
        * and inclass example where passwords has to be verified
        * with a hashed password on the database
        *
        * @access public
        * @param  string  $email     The user's supposed email address
        * @param  string  $password  The user's supposed password
        * @return boolean            Ttrue if the insert was successful, otherwise false
        */
        public function verifyUser($email, $password)
        {

            //query() for select
            $select = "SELECT password FROM admins WHERE email=:email";
            $statement = $this->_pdo->prepare($select);

            //bind inputs
            $statement->bindValue(':email', $email, PDO::PARAM_STR);

            //execute query
            $statement->execute();

            //retrieve a single row
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if($row == null){
              return false; // no username is found
            } else {
              $hash = $row['password'];

              //this will verify whether the password given matches
              //the hash in the database
              return password_verify($password, $hash);
            }
          }

        /**
         * Method for selecting a user from the DB based off school email
         *
         * This method queries the DB for information about a user
         * based off a given email address, returning everything about 
         *
         * @access public
         * @param  string  $school_email     The post data being passed from the controller
         * @return array   $row              The assoc array of user information
         */
          function getUserByEmail($school_email)
          {
              $pdo = getConnection();

              $select = 'SELECT * FROM profiles WHERE school_email=:school_email';

              $statement = $pdo->prepare($select);

              $statement->bindValue(':school_email', $school_email, PDO::PARAM_STR);

              $statement->execute();

              $row = $statement->fetchAll(PDO::FETCH_ASSOC);

              return $row;
          }

        /**
         * Method for selecting all displayable users
         *
         * This method runs a query on the DB grabbing
         * all users who are approved for being featured
         * on the site. This means their visibility boolean is set to true
         * while their queued boolean is set to false. Since this method is primarily used for
         * the home page, not every field is selected.
         *
         * @access public
         * @return array  $rows   An assoc array with all of the displayable users.
         *                        This array is two dementional, each array index in $rows
         *                        corresponds to an array of values for that user.
         */
          public function getDisplayableUsers()
          {

              $select = "SELECT id, fname, lname, image_path, graduation FROM profiles WHERE visibility = 1 AND queued = 0";

              $results = $this->_pdo->query($select);

              $rows = $results->fetchAll(PDO::FETCH_ASSOC);

              return $rows;
          }
       
        /**
         * Method for selecting all active users
         *
         * This method runs a query on the DB grabbing
         * all users who are approved for being featured
         * on the site. This means their visibility boolean is set to true
         * while their queued boolean is set to false. 
         *
         * @access public
         * @return array  $rows   An assoc array with all of the "active" users.
         *                        This array is two dementional, each array index in $rows
         *                        corresponds to an array of values for that user.
         */
          public function getAllActiveUsers()
          {

              $select = "SELECT * FROM profiles WHERE visibility = 1 AND queued = 0";

              $results = $this->_pdo->query($select);

              $rows = $results->fetchAll(PDO::FETCH_ASSOC);

              return $rows;
          }
       
        /**
         * Method for selecting all pending users
         *
         * This method runs a query on the DB grabbing
         * all users who are pending being featured
         * on the site. This means their visibility boolean is set to false
         * while their queued boolean is set to true. 
         *
         * @access public
         * @return array  $rows   An assoc array with all of the pending users.
         *                        This array is two dementional, each array index in $rows
         *                        corresponds to an array of values for that user.
         */
          public function getAllPendingUsers()
          {

              $select = "SELECT * FROM profiles WHERE visibility = 0 AND queued = 1";
              $results = $this->_pdo->query($select);

              $rows = $results->fetchAll(PDO::FETCH_ASSOC);

              return $rows;
          }

        /**
         * Method for selecting all archived users
         *
         * This method runs a query on the DB grabbing
         * all users who are archived on the site.
         * This means their visibility boolean is set to false
         * while their queued boolean is set to false.
         *
         * @access public
         * @return array  $rows   An assoc array with all of the archived users.
         *                        This array is two dementional, each array index in $rows
         *                        corresponds to an array of values for that user.
         */
          public function getAllPArchivedUsers()
          {

              $select = "SELECT * FROM profiles WHERE visibility = 0 AND queued = 0";
              $results = $this->_pdo->query($select);

              $rows = $results->fetchAll(PDO::FETCH_ASSOC);

              return $rows;
          }

        /**
         * Method for selecting a single user
         *
         * This method runs a query on the DB grabbing
         * all of the relevent information about a user
         * based off a given id number. Since this method
         * is primarily used for filling a profile page it
         * only grabs whats needed for the profile
         * 
         * @access public
         * @param  integer  $id   The id of the uer
         * @return array    $row  An assoc array with all of the displayable users.
         *                        This array is two dementional, each array index in $rows
         *                        corresponds to an array of values for that user.
         */
          public function getSingleUser($id)
          {

              $select = "SELECT id, fname, lname, image_path, degree, technologies, bio, veteran, twitter, linkedin, facebook, github, portfolio, graduation FROM profiles
                               WHERE id=:id";

              $statement = $this->_pdo->prepare($select);

              $statement->bindValue(':id', $id, PDO::PARAM_INT);
              $statement->execute();

              $row = $statement->fetch(PDO::FETCH_ASSOC);
              $row['technologies'] = explode(', ', $row['technologies']);
              return $row;
          }

          public function updateUser($data)
          {
            if (isset($data['image_path']) && $data['image_path'] == '') {
                require_once('photo-upload.php');
                $data['image_path'] = handleImage();
            } 
              $statement = 'UPDATE profiles SET fname=:fname, lname=:lname, school_email=:schoolEmail, prime_email=:primaryEmail,
              bio=:bio, twitter=:twitter, facebook=:facebook, github=:github, portfolio=:portfolio, linkedin=:linkedin, image_path=:imagePath WHERE id=:id';

              $statement = $this->_pdo->prepare($statement);

              $statement->bindValue(':id', intval($data['id']), PDO::PARAM_INT);
              $statement->bindValue(':fname', $data['fname'], PDO::PARAM_STR);
              $statement->bindValue(':lname', $data['lname'], PDO::PARAM_STR);
              $statement->bindValue(':schoolEmail', $data['school_email'], PDO::PARAM_STR);
              $statement->bindValue(':primaryEmail', $data['prime_email'], PDO::PARAM_STR);
              $statement->bindValue(':bio', $data['bio'], PDO::PARAM_STR);
              $statement->bindValue(':twitter', $data['twitter'], PDO::PARAM_STR);
              $statement->bindValue(':facebook', $data['facebook'], PDO::PARAM_STR);
              $statement->bindValue(':github', $data['github'], PDO::PARAM_STR);
              $statement->bindValue(':portfolio', $data['portfolio'], PDO::PARAM_STR);
              $statement->bindValue(':linkedin', $data['linkedin'], PDO::PARAM_STR);
              $statement->bindValue(':imagePath', $data['image_path'], PDO::PARAM_STR);

              return $statement->execute();
          }

          public function approveProfile($id)
          {

              $statement = 'UPDATE profiles SET visibility = 1, queued = 0 WHERE id=:id';

              $statement = $this->_pdo->prepare($statement);

              $statement->bindValue(':id', $id, PDO::PARAM_INT);

              return $statement->execute();
          }

          public function hideProfile($id)
          {

              $statement = 'UPDATE profiles SET visibility = 0, queued = 1 WHERE id=:id';

              $statement = $this->_pdo->prepare($statement);

              $statement->bindValue(':id', $id, PDO::PARAM_INT);

              return $statement->execute();
          }
          
          public function eliminateProfile($id)
          {

              $statement = 'DELETE FROM profiles WHERE id=:id';

              $statement = $this->_pdo->prepare($statement);

              $statement->bindValue(':id', $id, PDO::PARAM_INT);

              return $statement->execute();
          }

        public function archiveProfile($id)
        {

            $statement = 'UPDATE profiles SET visibility = 0, queued = 0 WHERE id=:id';

            $statement = $this->_pdo->prepare($statement);

            $statement->bindValue(':id', $id, PDO::PARAM_INT);

            return $statement->execute();
        }
        
        /**
        * Method to login in a verified user
        *
        * This method calls getUser and verifyUser
        * to avoid redundancy
        *
        * @access public
        * @param  array $data The $_POST array with all contents from the login form
        * @return true if the insert was successful, otherwise false
        */
        public function login($data)
        {
            //errors array 
            $errors = array();
            
            //read in and validate the login email
            if(isset($_POST['username']) && strlen($_POST['username']) > 1 && strlen($_POST['username']) <= 40 ) {
                $username = $_POST['username'];
            } else {
                $errors['username-error'] = 'Please enter your username';
            }
            
            //read in and validate the login password
            if(isset($_POST['password']) && strlen($_POST['password']) >= 4 && strlen($_POST['password']) <= 20 ) {
                $password = $_POST['password'];
            } else {
                $errors['password-error'] = 'Please enter your password';
            }
            if (sizeof($errors) == 0) {
                $select = "SELECT username, password, admin FROM admins WHERE username=:username";
                $statement = $this->_pdo->prepare($select);
                
                //bind inputs
                $statement->bindValue(':username', $username, PDO::PARAM_STR);
                
                //execute query
                $statement->execute();
    
                //retrieve a single row
                $row = $statement->fetch(PDO::FETCH_ASSOC);                                  
                                
                if ($row == null) {
                    return false; //no username is found...
                } else {
                    if( strcmp($password, $row['password']) == 0) {
                        $user = array();
                        $user['username'] = $row['username'];
                        $user['admin'] = $row['admin'];
                        return $user;
                    } else {
                        $errors['login-error'] = 'There was an issue logging you in';
                        return $errors;
                    }
                }
            } else {
                return $errors;
            }
        }
    }
?>
