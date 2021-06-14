<?php

class Credentials extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('htmlpurifier');
        $this->load->library('form_validation');
        $this->load->library('PHPMailer_Lib');
        $this->load->library('upload');
        $this->load->library('session');
        $this->load->library('Common');
        $this->load->helper('url', 'text', 'form', 'file', 'html');
        $this->load->model('User');
    }

    private function google($type)
    {
        $client = new \Google\Client();

        $clientID = \Common::GOOGLE_CLIENT_ID;
        $clientSecret = \Common::GOOGLE_CLIENT_KEY;
        $redirectUri =  rtrim(base_url(), "/") . '/credentials/google_login/' . $type;

        $client->setClientId($clientID);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
        $client->addScope("email");
        $client->addScope("profile");
        return $client;
    }

    public function get_google($type)
    {
        $client = $this->google($type);
        $url = $client->createAuthUrl();
        header('Location: ' . $url);
    }

    public function google_login($type)
    {
        $data = new stdClass();
        $client = $this->google($type);
        $google_oauth = new \Google_Service_Oauth2($client);
        $code = $_GET['code'] ?? "";
        if ($code) {
            $token = $client->fetchAccessTokenWithAuthCode($code);
            $access_token = $token['access_token'] ?? "";
            if (!$access_token) {
                $data->successPage = "/credentials/login";
                return;
            }
            $client->setAccessToken($token['access_token']);
            $google_account_info = $google_oauth->userinfo->get();
            $email = $google_account_info->email;
            $first_name = $google_account_info->given_name;
            $last_name = $google_account_info->family_name;
            $oauth_provider = "Google";
            $gender = "Male";
            $hash_password = $google_account_info->id;
            if ($type == "login") {
                $user = $this->User->check($email);
                if (!$user) {
                    $data->status = FALSE;
                    $data->title = "Error";
                    $data->page = "/credentials/signup";
                    $data->message = "This User is not registred";
                } else {
                    $id = $this->User->get_id($email)[0]->id;
                    $role = $this->User->get_role($email)[0]->type;
                    $session_data = array(
                        'id' => $id,
                        'email' => $email,
                        'role' => $role
                    );
                    $this->session->set_userdata($session_data);
                    $data->status = TRUE;
                    $data->page = "/profile";
                    $data->message = "User is logged in";
                }
            } else {
                $user = null;
                $users = $this->User->check($email);
                if ($users) {
                    $data->status = FALSE;
                    $data->title = "Error";
                    $data->page = "/credentials/login";
                    $data->message = "This User is already registred, Please Login";
                } else {
                    if ($type == "buyer") {
                        $user = $this->User->save_signup($oauth_provider, $gender, $hash_password, $first_name, $last_name, $email, $type, $mobile = null, $image_path = null);
                    } else if ($type == "seller") {
                        $user = $this->User->save_signup($oauth_provider, $gender, $hash_password, $first_name, $last_name, $email, $type, $mobile = null, $image_path = null);
                    } else {
                        return;
                    }
                    if ($user) {
                        $data->status = TRUE;
                        $data->title = "Success";
                        $data->page = "/profile";
                        $data->message = "new user created";
                    }
                }
            }
        } else {
            $data->status = FALSE;
            $data->title = "Error";
            $data->page = "/";
            $data->message = "Something went wrong try again";
        }
        if ($data->status) {
            header('Location: ' . $data->page);
            return;
        } else {
            $this->template->load('default_layout', 'content', 'credentials/google', $data);
        }
    }

    /**
     * @method({"get"})
     */
    public function signup()
    {
        $data = new stdClass();
        $this->template->load('default_layout', 'content', 'credentials/signup', $data);
    }

    public function postsignup()
    {
        $data = new stdClass();
        $this->form_validation->set_rules('first_name', 'First Name', 'required|alpha');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile Name', 'required|numeric|exact_length[10]');
        $this->form_validation->set_rules('password', 'Passsword ', 'required|min_length[8]|max_length[16]');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data->status = FALSE;
            $data->title = "validation error";
            $data->message = validation_errors();
        } else {
            $first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $gender = $this->input->post('gender');
            $type = $this->input->post('type');
            $mobile = $this->input->post('mobile');
            $oauth_provider = 'Codeigniter';
            $image_path = $this->image($email, $data);
            if ($image_path) {
                $this->load->model('User');
                $hash_password = sha1($password);
                // $emailsend = $this->send();
                $user = $this->User->save_signup($oauth_provider, $gender, $hash_password, $first_name, $last_name, $email, $type, $mobile, $image_path);
                if ($user) {
                    $data->status = TRUE;
                    $data->title = "Success";
                    $data->message = "new user created";
                    $data->page = "/credentials/login";
                }
            } else {
                $data->status = FALSE;
                $data->title = "Error";
                $data->message = "This email id is already registrated";
            }
        }
        echo json_encode($data);
    }

    public function login()
    {
        $data = new stdClass();
        $this->template->load('default_layout', 'content', 'credentials/login', $data);
    }

    public function postlogin()
    {
        $data = new stdClass();
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data->status = FALSE;
            $data->title = "validation error";
            $data->message = validation_errors();
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $hash_password = sha1($password);
            $this->load->model('User');
            $users = $this->User->check($email);
            if ($users) {
                $user = $this->User->check_credentials($email, $hash_password);
                $id = $this->User->get_id($email)[0]->id;
                $role = $this->User->get_role($email)[0]->type;
                if ($user) { //take a look & change the $role
                    $session_data = array(
                        'id' => $id,
                        'email' => $email,
                        'role' => $role
                    );
                    $this->session->set_userdata($session_data);
                    $data->status = TRUE;
                    $data->message = "User is logged in";
                    $data->page = '/profile';
                } else {
                    $data->status = FALSE;
                    $data->title = "Invalid";
                    $data->message = "Credentials are not match";
                    $data->page = '/credentials/login';
                }
            } else {
                $data->status = FALSE;
                $data->title = "Error";
                $data->message = "This user is not registred";
                $data->page = '/credentials/login';
            }
        }
        echo json_encode($data);
    }


    public function logout()
    {
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role');
        $this->session->sess_destroy();
        redirect('/');
    }


    private function image($email, $data): string
    {
        $file_name = explode('@', $email);
        $image = $file_name[0];
        $image_path = '';
        $config['upload_path'] = './static/images/profiles';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['file_name'] = $image;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('image')) {
            $data->status = FALSE;
            $data->message = $this->upload->display_errors();
            return '';
        } else {
            $product = $this->upload->data();
            $image_path = $product['file_name'];
        }
        return $image_path;
    }

    public function sendemail()
    {
        $data = new stdClass();
        $this->load->library('email');

        $this->email->from(set_value('email'), "Gulshan");
        $this->email->to("196301042@gkv.ac.in");
        $this->email->subject("Registratiion Greeting..");

        $this->email->message("Thank  You for Registratiion");
        $this->email->set_newline("\r\n");
        $this->email->send();

        if (!$this->email->send()) {
            $data = $this->email->print_debugger();
        } else {
            $data = "Email not send";
        }
        return $data;
    }

    function send()
    {
        // Load PHPMailer library
        $this->load->library('phpmailer_lib');

        // PHPMailer object
        $mail = $this->phpmailer_lib->load();
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host     = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'fet@gkv.ac.in';
        $mail->Password = '********';
        $mail->SMTPSecure = 'ssl';
        $mail->Port     = 465;

        // print_r($mail); die;
        $mail->setFrom('fet@gkv.ac.in', 'Deadpool');
        $mail->addReplyTo('abhi@gmail.com', 'Gulshan');

        // Add a recipient
        $mail->addAddress('deadpool@gmail.com');

        // Add cc or bcc 
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        // Email subject
        $mail->Subject = 'Send Email via SMTP using PHPMailer in CodeIgniter';
        // Set email format to HTML
        $mail->isHTML(true);
        // Email body content
        $mailContent = "<h1>Send HTML Email using SMTP in CodeIgniter</h1>
            <p>This is a test email sending using SMTP mail server with PHPMailer.</p>";
        $mail->Body = $mailContent;
        // Send email
        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            return 0;
        } else {
            echo 'Message has been sent';
            return 1;
        }
    }
}
