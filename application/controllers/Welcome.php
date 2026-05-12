<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url', 'file']);
        $this->load->library('upload');
        $this->load->model('Application_model');
		$this->load->library('form_validation');
    }

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function three_pl_form(){
		$data['result'] = true;
		return $this->load->view("3_pl_form", $data);
	}

	// ------------------------------
    // TEMP UPLOAD
    // ------------------------------
    public function upload_temp()
    {
        if (!empty($_FILES['file']['name'])) {

            $temp_path = FCPATH.'uploads/temp/';
            if(!is_dir($temp_path)) mkdir($temp_path, 0755, true);

            $config['upload_path'] = $temp_path;
            $config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx';
            $config['max_size'] = 2048; // 2MB
            $config['encrypt_name'] = TRUE;

            $this->upload->initialize($config);

            if($this->upload->do_upload('file')) {
                $data = $this->upload->data();
                $file_name = $data['file_name'];
                $file_url = base_url('uploads/temp/'.$file_name);

                echo json_encode(['status'=>'success', 'temp_file'=>$file_name, 'file_url'=>$file_url]);
            } else {
                echo json_encode(['status'=>'error', 'message'=>$this->upload->display_errors()]);
            }

        } else {
            echo json_encode(['status'=>'error', 'message'=>'No file selected']);
        }
    }

    // ------------------------------
    // DELETE TEMP FILE
    // ------------------------------
    public function delete_temp()
    {
        if ($this->input->method() !== 'post') {
            show_error('Invalid request method', 405);
        }

        $file = basename((string) $this->input->post('file', true));
        if ($file === '' || !preg_match('/^[A-Za-z0-9._-]+$/', $file)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid file name']);
            return;
        }

        $directory = realpath(FCPATH.'uploads/temp');
        $path = $directory ? realpath($directory.DIRECTORY_SEPARATOR.$file) : false;

        if ($directory && $path && strpos($path, $directory.DIRECTORY_SEPARATOR) === 0 && is_file($path)) {
            unlink($path);
            echo json_encode(['status'=>'success']);
        } else {
            echo json_encode(['status'=>'error', 'message'=>'File not found']);
        }
    }

	public function save_application() {
        $this->load->helper(['string', 'url']);
        
        if ($this->input->method() !== 'post') {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
            return;
        }

        // --- Validation rules ---
        $this->form_validation->set_rules('options', 'Referral Option', 'required|in_list[yes,no]');
        $this->form_validation->set_rules('rider_full_name', 'Rider Full Name', 'trim|required|min_length[3]|max_length[150]');
        $this->form_validation->set_rules('rider_mobile', 'Rider Mobile', 'trim|required|regex_match[/^[0-9]{10}$/]');
        $this->form_validation->set_rules('rider_iqama_id', 'Rider Iqama/ID', 'trim|required|numeric|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('rider_iqama_expiry', 'Iqama/ID Expiry Date', 'required');
        $this->form_validation->set_rules('nationality', 'Nationality', 'required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[150]');
        $this->form_validation->set_rules('dob', 'Date of Birth', 'required');
        $this->form_validation->set_rules('rider_city', 'Rider City', 'required');
        $this->form_validation->set_rules('rider_iban', 'Rider IBAN', 'trim|required|alpha_numeric|min_length[24]|max_length[24]');

        if ($this->form_validation->run() == FALSE) {
            $errors = [];
            foreach ($_POST as $key => $val) {
                if (form_error($key)) {
                    $errors[$key] = strip_tags(form_error($key));
                }
            }
            echo json_encode(['status' => 'error', 'errors' => $errors]);
            return;
        }

        // --- Referrer validation ---
        if ($this->input->post('options') === 'yes') {
            $this->form_validation->set_rules('referrer_full_name', 'Referrer Full Name', 'trim|required|min_length[3]|max_length[150]');
            $this->form_validation->set_rules('referrer_mobile', 'Referrer Mobile', 'trim|required|regex_match[/^[0-9]{10}$/]');
            $this->form_validation->set_rules('referrer_iqama_id', 'Referrer Iqama/ID', 'trim|required|numeric|min_length[10]|max_length[10]');
            $this->form_validation->set_rules('referrer_hungerstation_id', 'Referrer HungerStation ID', 'trim|required|numeric');
            $this->form_validation->set_rules('referrer_iban', 'Referrer IBAN', 'trim|required|alpha_numeric|max_length[34]');

            if ($this->form_validation->run() === FALSE) {
                $errors = [];
                foreach ($_POST as $key => $val) {
                    if (form_error($key)) {
                        $errors[$key] = strip_tags(form_error($key));
                    }
                }
                echo json_encode(['status' => 'error', 'errors' => $errors]);
                return;
            }
        }

        // --- Calculate age ---
        $dob = $this->input->post('dob');
        $age = null;
        if ($dob) {
            $today = new DateTime();
            $birth = new DateTime($dob);
            $age = $today->diff($birth)->y;
        }

        // --- Collect form data ---
        $data = [
            'is_referral'               => $this->input->post('options'),
            'referrer_full_name'        => $this->input->post('referrer_full_name'),
            'referrer_mobile'           => $this->input->post('referrer_mobile'),
            'referrer_iqama_id'         => $this->input->post('referrer_iqama_id'),
            'referrer_hungerstation_id' => $this->input->post('referrer_hungerstation_id'),
            'referrer_iban'             => $this->input->post('referrer_iban'),
            'rider_full_name'           => $this->input->post('rider_full_name'),
            'rider_mobile'              => $this->input->post('rider_mobile'),
            'rider_iqama_id'            => $this->input->post('rider_iqama_id'),
            'rider_iqama_expiry'        => $this->input->post('rider_iqama_expiry'),
            'nationality'               => $this->input->post('nationality'),
            'email'                     => $this->input->post('email'),
            'dob'                       => $dob,
            'rider_city'                => $this->input->post('rider_city'),
            'rider_iban'                => $this->input->post('rider_iban'),
            'saudi_status'              => $this->input->post('saudi_status') ?? 'Non-Saudi',
        ];

        // --- Handle uploaded files ---
        $uploaded_files = $this->input->post('uploaded_files') ?? []; // from frontend
        $file_fields = ['iqama_file','license_file','iban_file','photo_file'];
        $final_path = FCPATH.'uploads/3pl_applications/';
        if(!is_dir($final_path)) mkdir($final_path, 0755, true);

        // ✅ Validate that all 4 files exist
        foreach ($file_fields as $index => $field) {
            if (empty($uploaded_files[$index])) {
                echo json_encode(['status' => 'error', 'errors' => [$field => ucfirst(str_replace('_',' ',$field)).' is required']]);
                return;
            }
        }

        // ✅ Move files to final folder
        foreach($file_fields as $index => $field) {
            $temp_file = $uploaded_files[$index];
            $ext = pathinfo($temp_file, PATHINFO_EXTENSION);
            $new_name = random_string('alnum', 8).'_'.time().'.'.$ext;

            $temp_path = FCPATH.'uploads/temp/'.$temp_file;
            $dest_path = $final_path.$new_name;

            if(file_exists($temp_path)) {
                if(rename($temp_path, $dest_path)) {
                    $data[$field] = 'uploads/3pl_applications/'.$new_name;
                } else {
                    echo json_encode(['status' => 'error', 'errors' => [$field => "Failed to move {$field}"]]);
                    return;
                }
            } else {
                echo json_encode(['status' => 'error', 'errors' => [$field => "{$field} not found in temp folder"]]);
                return;
            }
        }

        // --- Save to database ---
        $insert_id = $this->Application_model->save_application($data);

        echo json_encode([
            'status' => 'success',
            'message' => 'Application submitted successfully',
            'id' => $insert_id
        ]);
    }

}
