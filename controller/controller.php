<?php
/**
 * This file plays middle-man between user interaction and data requests
 *
 * This file is to handle requestions on the front-end and decide
 * what should happen next, whether it be forwarding the user to another page,
 * back to where they where previously, or pull/push data to/from the back-end.
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
    session_start();

    /**
     * This class creates a Controller object
     *
     * @author     Jacob Laqua <jlaqua@mail.greenriver.edu>
     * @author     Mackenzie Larson <mlarson28@mail.greenriver.edu>
     * @author     Michael Peterson <mpeterson47@mail.greenriver.edu>
     * @version    @version Release: 1.0
     */
    class Controller
    {
        private $_f3; //router

        /**
         * Creates a new f3 object and sets the
         * nav bar location for use on view pages
         *
         * @access public
         * @param object $f3   The f3 router being passed
         */
        public function __construct($f3)
        {
            $this->_f3 = $f3;
            $this->_f3->set('nav', 'view/modules/nav.php');
            $this->_f3->set('head_title', 'view/modules/head.php');
            $this->_f3->set('problems', 'view/modules/error-display.php');
            $this->_f3->set('footer', 'view/modules/footer.php');
        }

        //methods

        /**
         * Method for logic to grab the data needed to build the home/default page
         *
         * This method is used by default upon landing landing on the site
         * and also when the user click "home" in the nav bar
         *
         * @access public
         */
        public function home()
        {
            //retrieve users
            $data = new DataLayer();
            // if isset(post) {
            	//$user = $data->logUser($_POST);
            //}
            $users = $data->getDisplayableUsers();
            //load the view
            $this->_f3->set('title', 'Home');
			$this->_f3->set('users', $users);
            echo Template::instance()->render('view/home.php');
        }

        /**
         * Method for logic to grab the data needed to build the signup page
         *
         * When a singup form is submitted validation occurs with the model
         * otherwise when the request method is GET simply load the view
         *
         * @access public
         */
        public function signup()
        {
            $this->_f3->set('title', 'Signup');
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST !== $_SESSION['last-set']) {
				$data = new DataLayer();
				
				//send post data to the model
				// $user will either return with user data or errors
				$user = $data->logUser($_POST);
				$_SESSION['last-set'] = $_POST;
				if (isset($user['school_email'])) {
					// the user is in the db
					// store the good data in session for the confirmation 
					$_SESSION['user'] = $user;
					header("Location: /confirmation");
                } else {
					$this->_f3->set('sticky', $_POST);
                    $this->_f3->set('errors', $user);
                }
            } else {
                $this->_f3->clear('errors');
				$this->_f3->clear('sticky');
            }
            //load the view
            echo Template::instance()->render('view/student-submit.php');
        } 

		public function confirmation()
		{
			//Prevent the user from navigating to the confirmation page on their own
			if (!isset($_SESSION['user'])) {
				header("Location: /home");
			} else {
				$this->_f3->set('title', "Confirmation");	
				$this->_f3->set('user', $_SESSION['user']);
				session_unset();
				session_destroy();
		  
				//load the view
				echo Template::instance()->render('view/confirmation.php');	
			}
		}

		public function login()
		{
			echo Template::instance()->render('view/login.php');
		}

        /**
         * Method for logic to log a user out.
         *
         * session is unset/destroyed and the user is sent home
         *
         * @access public
         */
        public function logout()
        {
            session_unset();
            session_destroy();
            header("Location: /dashboard");
        }

		public function about()
		{
			$data = new DataLayer();

			$this->_f3->set('title', "About");
			echo Template::instance()->render('view/about.php');
		}

		public function page($id)
		{
			$data = new DataLayer();

			//send post data to the model
            $user = $data->getSingleUser($id);
			
			//Figure out how many social media links are filled in
			$count = 0;
			$social = array();
			//check Linkedin
			if (strpos($user['linkedin'], "http") !== false) {
				$count++;
			} else {
				$user['linkedin'] == '';
			}
			if (strpos($user['github'], "http") !== false) {
				$count++;
			} else {
				$user['github'] == '';
			}
			if (strpos($user['twitter'], "http") !== false) {
				$count++;
			} else {
				$user['twitter'] == '';
			}
			if (strpos($user['facebook'], "http") !== false) {
				$count++;
			} else {
				$user['facebook'] == '';
			}
			if (strpos($user['portfolio'], "http") !== false) {
				$count++;
			} else {
				$user['portfolio'] == '';
			}
			
			//set bootstrap cols
			if ($count == 1) {
				$cols = 'col-xs-12';
			} else if ($count == 2) {
				$cols = 'col-xs-6';
			} else if ($count == 3) {
				$cols = 'col-xs-4';
			} else if ($count == 4) {
				$cols = 'col-xs-3';
			} else if ($count == 5) {
				$cols = 'col-xs-2';
				$offset = 'view/modules/single-column-spacer.php';
				$this->_f3->set('offset', $offset);
			} else {
				$cols = '';
			}

			$this->_f3->set('title', $user['fname'] . " " . $user['lname']);
			$this->_f3->set('user', $user);
			$this->_f3->set('cols', $cols);
			echo Template::instance()->render('view/profile.php');
		}

		public function show($id)
		{
			$data = new DataLayer();

			//send post data to the model
            $data->approveProfile($id);
			header("Location: /dashboard");
		}

		public function hide($id)
		{
			$data = new DataLayer();

			//send post data to the model
            $data->hideProfile($id);
			header("Location: /dashboard");
		}
		
		public function eliminate($id)
		{
			$data = new DataLayer();

			//send post data to the model
            $data->eliminateProfile($id);
			header("Location: /dashboard");
		}

		public function archive($id)
		{
			$data = new DataLayer();

			//send post data to the model
            $data->archiveProfile($id);
			header("Location: /dashboard");
		}

		public function dashboard()
		{
			$data = new DataLayer();
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username'])) {
				//log the user in
				$user = $data->login($_POST);
				if ($user['admin'] == 1) {
					$_SESSION['logged'] = $user;
				}
			}
			if ($_SERVER['REQUEST_METHOD'] == 'POST') { // a form is being submitted (updated)
				$user = $data->updateUser($_POST);
			}
			if (isset($_SESSION['logged'])) { 
				$users = $data->getAllActiveUsers();
				$pendindUsers = $data->getAllPendingUsers();
				$this->_f3->set('users', $users);
				$this->_f3->set('pendingUsers', $pendindUsers);
			}
            //load the view
            $this->_f3->set('title', 'Admin Dashboard');
			echo Template::instance()->render('view/admin/dashboard.php');
		}
    }
?>
