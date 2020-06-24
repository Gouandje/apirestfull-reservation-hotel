public function data_delete(){
$id = $this->uri->segment(3);
if($id===NULL){
$this->set_response([
'status' => FALSE,
'error' => 'ID cannot be empty'
], REST_Controller::HTTP_NOT_FOUND);
}
$data = $this->API_model->delete($id);
if ($data)
{
$this->set_response($data, REST_Controller::HTTP_OK);
}
else
{
$this->set_response([
'status' => FALSE,
'error' => 'Record could not be found'
], REST_Controller::HTTP_NOT_FOUND);
}
}