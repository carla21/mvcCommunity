<?php
class Users extends Controller{
	public function __construct(){
		$this->userModel = $this->model('User');
	}
	public function register(){
		$data = [
			'username' => '',
			'email' => '',
			'password' => '',
			'confirmPassword' => '',
			'usernameError' => '',
			'emailError' => '',
			'passwordError' => '',
			'confirmPasswordError' => ''
		];
		// it is true
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			//sanatize post data
			//and process form
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				$data = [
					'username' => trim($_POST['username']),
					'email' => trim($_POST['email']),
					'password' => trim($_POST['password']),
					'confirmPassword' => trim($_POST['confirmPassword']),
					'usernameError' => '',
					'emailError' => '',
					'passwordError' => '',
					'confirmPasswordError' => ''
				];	
				
				$nameValidation = "/^[a-zA-Z0-9]*$/";
				$passwordValidation = "/^(.{0,7}|[^a-z]*|[^\d]*)$/i";
				
				//validate username on letters/numbers
				if (empty($data['username'])){
					$data['usernameError'] = 'Please enter username.';	
				} elseif (!preg_match($nameValidation, $data['username'])){
					$data['usernameError'] = 'Name can only contain letters and numbers.';	
				}
				
				//validate email address
				if (empty($data['email'])) {
					$data['emailError'] = 'Please enter email address.';	
				} elseif(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
					$data['emailError'] = 'Please enter correct email address format.';			
				} else {
				//check if email exists.
				if ($this->userModel->findUserByEmail($data['email'])){
					$data['emailError'] = 'Email already exist.';						
				}
			}		
			//validate password on length and numeric values
				if(empty($data['password'])){
					$data['passwordError'] = 'Please enter password.';	
				} elseif(strlen($data['password']) < 6){
					$data['passwordError'] = 'Password must be at least 8 characters long.';
				}elseif (preg_match($passwordValidation, $data['password'])){
					$data['passwordError'] = 'Password must have at leastt one numeric value.';	
					}
					
			//validate confirmPassword
				if(empty($data['confirmPassword'])){
				$data['confirmPasswordError'] = 'Confirm password.';	
			 } else {
				 if ($data['password'] != $data['confirmPassword']){
					$data['confirmPasswordError'] = 'Password do not match, please try again.';
				 }				
			}
			//if the errors are empty
			if(empty($data['usernameError']) && empty($data['emailError']) && empty($data['passwordError']) && empty($data['confirmPasswordError'])){
					
					//hash password
					$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
					
					//register user from model function
					if ($this->userModel->register($data)){
						//redirect to login page
						header('location: ' . URLROOT . '/users/login');						
					} else {
						die('something went wrong.');
						}
					}
				}
				$this->view('users/register', $data);
				}
				public function login() {
				$data = [
				'title' => 'Login page',
				'username' =>'',
				'password' => '',
				'usernameError' => '',
				'passwordError' => ''
				];
				
				//check for the post by creating a if statement
				if($_SERVER['REQUEST_METHOD'] == 'POST'){
					//sanatize post data
					$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
					
					$data = [
					'username'=> trim($_POST['username']),
					'password'=> trim($_POST['password']),
					'usernameError'=> '',
					'passwordError'=> '',
					];
					//validate username
					if(empty($data['username'])){
						$data['passwordError'] = 'please enter a your username.';					
					}
					//validate password
					if(empty($data['password'])){
						$data['usernameError'] = 'please enter a your password.';
					}
					
					//check if all error are empty
					if (empty($data['usernameError']) && empty($data['passwordError'])){
						$loggedInUser = $this->userModel->login($data['username'], $data['password']);
						
						if ($loggedInUser) {
							$this->createUserSession($loggedInUser);
						} else {
							$data['passwordError'] = 'Password or username is incorrect. Please try again.';
							
							$this->view('users/login',$data);
						}										
					}					
				} else {
					$data = [
				'username' =>'',
				'password' => '',
				'usernameError' => '',
				'passwordError' => ''
				];
				}
				$this->view('users/login', $data);
			}
			 public function createUserSession($user) {
				$_SESSION['user_id'] = $user->id;
				$_SESSION['username'] = $user->username;
				$_SESSION['email'] = $user->email;
				header('location:' . URLROOT . '/pages/index');
			}
			public function logout(){				
				unset($_SESSION['user_id']);
				unset($_SESSION['username']);
				unset($_SESSION['email']);
				header('location:' . URLROOT . '/users/login');
			}
		}