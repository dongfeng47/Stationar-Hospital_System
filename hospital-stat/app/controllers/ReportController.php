<?php
require_once __DIR__ . '/../models/Report.php';
require_once __DIR__ . '/../models/Log.php'; // 🔹 подключаем лог
require_once __DIR__ . '/../controllers/DashboardController.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use Mpdf\Mpdf;

class ReportController
{
    private $model;
    private $logModel; // модель для логов

    public function __construct()
    {
        $this->model = new Report();
        $this->logModel = new Log(); //инициализация логов
    }

    public function index()
    {
        AuthController::checkRole(['admin', 'statistician']);

        $role = $_SESSION['user']['Role'] ?? '';
        $menuItems = DashboardController::getMenuByRole($role);

        $selectedTopic = $_POST['topic'] ?? '';
        $filters = $_POST ?? [];

        require_once __DIR__ . '/../models/Doctors.php';
        $doctorModel = new Doctors();
        $doctors = $doctorModel->getAll();

        require_once __DIR__ . '/../models/Ward.php';
        $wardModel = new Ward();
        $wards = $wardModel->getAll();

        $reportData = [];
        if ($selectedTopic) {
            $reportData = $this->model->getReportData($selectedTopic, $filters);
        }

        $content = __DIR__ . '/../views/reports/index.php';
        include __DIR__ . '/../views/layouts/main.php';
    }

    public function loadForm($topic)
    {
        AuthController::checkRole(['admin', 'statistician']);

        $formHtml = '';
        switch ($topic) {
            case 'procedure':
                require_once __DIR__ . '/../models/Doctors.php';
                $doctorModel = new Doctors();
                $doctors = $doctorModel->getAll();
                ob_start();
                require __DIR__ . '/../views/reports/forms/procedureForm.php';
                $formHtml = ob_get_clean();
                break;

            case 'hospitalization':
                require_once __DIR__ . '/../models/Doctors.php';
                require_once __DIR__ . '/../models/Ward.php';
                $doctorModel = new Doctors();
                $wardModel = new Ward();
                $doctors = $doctorModel->getAll();
                $wards = $wardModel->getAll();
                ob_start();
                require __DIR__ . '/../views/reports/forms/hospitalizationForm.php';
                $formHtml = ob_get_clean();
                break;

            case 'diagnosis':
                ob_start();
                require __DIR__ . '/../views/reports/forms/diagnosisForm.php';
                $formHtml = ob_get_clean();
                break;

            default:
                $formHtml = "<p>" . __('form_not_found') . "</p>";
        }

        echo $formHtml;
        exit;
    }

    public function exportPDF()
    {
        AuthController::checkRole(['admin', 'statistician']);

        $topic = $_POST['topic'] ?? '';
        $filters = $_POST ?? [];
        $reportData = $this->model->getReportData($topic, $filters);

        $topicTranslated = match ($topic) {
            'hospitalization' => __('hospitalization_report'),
            'procedure' => __('procedure_report'),
            'diagnosis' => __('diagnosis_report'),
            default => __('report_title')
        };

        // лог генерац отчет
        $userId = $_SESSION['user']['Id'] ?? null;
        $this->logModel->create(
            $userId,
            __('pdf_report_generated') . ': ' . $topicTranslated

        );

        // код генерации пдф
        $columnsMap = [
            'Department' => __('department'),
            'WardNumber' => __('ward_number'),
            'HospitalizationsCount' => __('hospitalizations_count'),
            'FirstAdmission' => __('first_admission'),
            'LastDischarge' => __('last_discharge'),
            'DiagnosisName' => __('diagnosis_name'),
            'PatientCount' => __('patients_count'),
            'ProcedureName' => __('procedure_name'),
            'ProcedureCount' => __('procedure_count'),
            'Doctor' => __('doctor'),
        ];

        $footerHtml = ' 
        <table width="100%" style="border-top:1px solid #FFFFFF; font-size:10pt; padding-top:5px; border-collapse:collapse;">
            <tr>
                <td width="33%" style="border:1px solid #FFFFFF; padding:5px;">' . __('generated_by') . ' ' . __('app_name') . '</td>
                <td width="33%" align="center" style="border:1px solid #FFFFFF; padding:5px;">' . __('page') . ' {PAGENO} ' . __('of') . ' {nb}</td>
                <td width="33%" align="right" style="border:1px solid #FFFFFF; padding:5px;">
                    ' . htmlspecialchars($topicTranslated) . '
                    <img src="' . __DIR__ . '/../../public/assets/icons/watermark.png" style="height:12pt; vertical-align:middle; margin-left:5px;">
                </td>
            </tr>
        </table>'; 

        $headerHtml = '
        <table width="100%" style="border:none; margin-bottom:10px; border-collapse:collapse;">
            <tr>
                <td width="15%" style="border:none;"><img src="' . __DIR__ . '/../../public/assets/icons/medicine.png" style="height:60px;"></td>
                <td width="70%" align="center" style="border:none;">
                    <h1 style="margin:0; font-size:20pt; font-weight:bold;">' . __('app_name') . '</h1>
                </td>
                <td width="15%" align="right" style="font-size:10pt; border:none;">{DATE d-m-Y}</td>
            </tr>
        </table>';

        $html = '
        <style>
            body { font-family: "DejaVu Sans", sans-serif; font-size: 12pt; color: #333; line-height:1.4; }
            h2 { text-align:center; font-size:16pt; margin-bottom:20px; font-weight:bold; }
            table { width:100%; border-collapse:collapse; margin-bottom:15px; table-layout:fixed; }
            th, td { padding:8px; border:1px solid #999; word-wrap:break-word; }
            th { background-color:#e0e0e0; font-weight:bold; text-align:center; }
            tr:nth-child(even) td { background-color:#f5f5f5; }
            td { text-align:left; }
            .no-data { text-align:center; font-style:italic; color:#777; }
        </style>
        <h2>' . htmlspecialchars($topicTranslated) . '</h2>';

        if (!empty($reportData)) {
            $html .= '<table><thead><tr>';
            foreach (array_keys($reportData[0]) as $col) {
                $header = $columnsMap[$col] ?? htmlspecialchars($col);
                $html .= '<th>' . htmlspecialchars($header) . '</th>';
            }
            $html .= '</tr></thead><tbody>';

            foreach ($reportData as $row) {
                $html .= '<tr>';
                foreach ($row as $val) {
                    $html .= '<td>' . htmlspecialchars($val) . '</td>';
                }
                $html .= '</tr>';
            }
            $html .= '</tbody></table>';
        } else {
            $html .= '<p class="no-data">' . __('no_report_data') . '</p>';
        }

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 35,
            'margin_bottom' => 25,
            'margin_header' => 10,
            'margin_footer' => 10,
            'default_font' => 'dejavusans',
            'default_font_size' => 12,
        ]);

        $mpdf->SetWatermarkImage(__DIR__ . '/../../public/assets/icons/h.png', 0.15); 
        $mpdf->showWatermarkImage = true;

        $mpdf->SetHTMLHeader($headerHtml);
        $mpdf->SetHTMLFooter($footerHtml);
        $mpdf->WriteHTML($html);

        $safeName = preg_replace('/[^\p{L}\p{N}_]+/u', '_', strtolower($topicTranslated));
        $filename = "{$safeName} " . date('d.m.Y') . ".pdf";

        $mpdf->Output($filename, \Mpdf\Output\Destination::DOWNLOAD);
        exit;
    }
}
