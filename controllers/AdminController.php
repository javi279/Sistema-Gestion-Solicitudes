// controllers/AdminController.php

class AdminController {
    public function dashboard() {
        // Retrieve request data from the SolicitudModel
        $solicitudModel = new SolicitudModel();
        $numRequests = $solicitudModel->getTotalRequests();
        $avgRequestDuration = $solicitudModel->getAverageRequestDuration();

        // Retrieve employee data from the EmpleadoModel
        $empleadoModel = new EmpleadoModel();
        $numEmployees = $empleadoModel->getTotalEmployees();
        $avgEmployeeRating = $empleadoModel->getAverageEmployeeRating();

        // Retrieve user data from the UsuarioModel
        $usuarioModel = new UsuarioModel();
        $numUsers = $usuarioModel->getTotalUsers();

        // Pass the data to the view
        $data = array(
            'numRequests' => $numRequests,
            'avgRequestDuration' => $avgRequestDuration,
            'numEmployees' => $numEmployees,
            'avgEmployeeRating' => $avgEmployeeRating,
            'numUsers' => $numUsers
        );

        // Render the view
        $this->view('admin/dashboard', $data);
    }
}