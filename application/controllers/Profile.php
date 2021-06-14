<?php

class Profile extends CI_Controller
{

    public function __construct()
    {
        parent::get_instance();
        parent::__construct();
        $this->load->helper('htmlpurifier');
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('PHPMailer_Lib');
        $this->load->library('session');
        $this->load->helper('url', 'text', 'form', 'file', 'html');
        if (!$this->session->userdata('id')) {
            redirect('/credentials/login');
        }
        $this->load->model('User');
        $this->load->model('Shop');
    }

    public function index()
    {
        $data = new stdClass();
        $email = $this->session->userdata('email');
        $user_id = $this->session->userdata('id');
        $role = $this->session->userdata('role');
        $data->user = $this->User->profile_data($email);
        if ($role == "buyer") {
            $data->profile = $this->User->buyer_data($user_id);
        } else if ($role == "seller") {
            $seller_id = $this->Shop->seller_id($user_id)[0]->id;
            $data->shop_id = $this->Shop->shop_id($seller_id);
            $data->profile = $this->User->seller_data($user_id);
        }
        $this->template->load('default_layout', 'content', 'credentials/profile', $data);
    }

    public function update()
    {
        $data = new stdClass();
        $this->form_validation->set_rules('first_name', 'First Name', 'required|alpha');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile Name', 'required|numeric|exact_length[10]');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data->status = FALSE;
            $data->title = "validation error";
            $data->message = validation_errors();
        } else {
            $uploaded_image = $this->input->post('uploaded_image');
            $first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');
            $gender = $this->input->post('gender');
            $mobile = $this->input->post('mobile');
            $email = $this->input->post('email');
            $type = $this->input->post('type');
            $user_id = $this->session->userdata('id');
            $image_path = $this->image($email, $data, $uploaded_image);
            if ($type == "seller") {
                $update = $this->User->update_seller_profile($first_name, $last_name, $gender, $mobile, $user_id, $image_path);
            } else if ($type == "buyer") {
                // $update;   update profile for buyer
                $update = $this->User->update_buyer_profile($first_name, $last_name, $gender, $mobile, $user_id, $image_path);
            } else {
                $data->status = false;
                $data->title = "error";
                $data->message = "Something went wrong";
                echo json_encode($data);
                return;
            }
            if ($update) {
                $data->status = TRUE;
                $data->title = "Success";
                $data->message = "Profile updated successfully";
                $data->page = "/profile";
            } else {
                $data->status = false;
                $data->title = "error";
                $data->message = "Something went wrong";
            }
        }
        echo json_encode($data);
    }

    private function image($email, $data, $uploaded_image): string
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
        } else {
            $product = $this->upload->data();
            $image_path = $product['file_name'];
        }
        if ($image_path) {
            if ($uploaded_image) {
                unlink('static/images/profiles/' . $uploaded_image);
            }
        }
        return $image_path;
    }

    function send()
    {
        // Load PHPMailer library
        $this->load->library('phpmailer_lib');

        // PHPMailer object
        $mail = $this->phpmailer_lib->load();

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host     = 'smtp.sendgrid.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'abhinavg90834@gmail.com';
        $mail->Password = 'Abhinav@89';
        $mail->SMTPSecure = 'ssl';
        $mail->Port     = 465;

        $mail->setFrom('abhinavg90834@gmail.com', 'Deadpool');
        $mail->addReplyTo('196301042@gkv.ac.in', 'Gulshan');

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
