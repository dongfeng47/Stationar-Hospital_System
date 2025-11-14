<div class="reports-section">
    <h2><?= __('reports') ?></h2>

    <form method="post" id="reportForm">
    <label for="topicSelect"><?= __('report_topic') ?>:</label>
<select name="topic" id="topicSelect" required>
<option value=""><?= __('select_topic') ?></option>
 <option value="diagnosis" <?= ($selectedTopic=='diagnosis')?'selected':'' ?>><?= __('report_by_diagnosis') ?></option>
<option value="procedure" <?= ($selectedTopic=='procedure')?'selected':'' ?>><?= __('report_by_procedure') ?></option>
 <option value="hospitalization" <?= ($selectedTopic=='hospitalization')?'selected':'' ?>><?= __('report_by_hospitalization') ?></option>
</select>
<div id="dynamicFilters">
 <?php
 if ($selectedTopic) {
   include __DIR__ . "/forms/{$selectedTopic}Form.php";
         }
         ?>
 </div>

        <button type="button" id="generateBtn"><?= __('generate') ?></button>
        <?php if (!empty($reportData)): ?>
            <button type="button" id="exportPdfBtn"><?= __('export_pdf') ?></button>
        <?php endif; ?>
    </form>

    <?php if (!empty($reportData)): ?>
        <?php
        $topicTranslated = match ($selectedTopic) {
            'diagnosis' => __('diagnosis_report'),
            'procedure' => __('procedure_report'),
            'hospitalization' => __('hospitalization_report'),
            default => __('report_title')
        };

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
        ?>
        <h3><?= __('report_results') ?>: <?= htmlspecialchars($topicTranslated) ?></h3>

        <table class="responsive-table">
            <thead>
                <tr>
                    <?php foreach(array_keys($reportData[0]) as $col): ?>
                        <th><?= htmlspecialchars($columnsMap[$col] ?? $col) ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach($reportData as $row): ?>
                    <tr>
                        <?php foreach($row as $val): ?>
                            <td><?= htmlspecialchars($val) ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<style>

.reports-section #exportPdfBtn {
    background-color: #D7412B; 
    color: white;
    border: none;
    border-radius: 6px;
    padding: 10px 20px;
    font-weight: 600;
    cursor: pointer;
    width: fit-content;
    transition: background-color 0.2s ease;
    margin-top: 10px;
}

.reports-section #exportPdfBtn:hover {
    background-color: #b03524;
}


.reports-section #generateBtn {
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 6px;
    padding: 10px 20px;
    font-weight: 600;
    cursor: pointer;
    width: fit-content;
    transition: background-color 0.2s ease;
    margin-top: 10px;
}

.reports-section #generateBtn:hover {
    background-color: #45a049;
}

</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const topicSelect = document.getElementById('topicSelect');
    const dynamicFilters = document.getElementById('dynamicFilters');
    const reportForm = document.getElementById('reportForm');
    const generateBtn = document.getElementById('generateBtn');
    const exportPdfBtn = document.getElementById('exportPdfBtn');

    const errorLoadForm = "<?= __('error_loading_form') ?>";
    const failedToLoadForm = "<?= __('failed_to_load_filters') ?>";




    // ункция подгрузк формы фильтров
    function loadFilters(topic, callback) {
        fetch(`index.php?controller=report&action=loadForm&topic=${topic}`)
            .then(response => {
                if (!response.ok) throw new Error(errorLoadForm);
                return response.text();
            })
            .then(html => {
                dynamicFilters.innerHTML = html;
                if (callback) callback();
            })
            .catch(err => {
                console.error(err);
                dynamicFilters.innerHTML = `<p style="color:red;">${failedToLoadForm}</p>`;
            });
    }




    // грузка фильтров при выборе темы
    topicSelect.addEventListener('change', function () {
        const topic = this.value;
        if (!topic) {
            dynamicFilters.innerHTML = '';
            return;
        }
        loadFilters(topic);
    });

    // Кнопка формировать
    generateBtn.addEventListener('click', function () {
        const topic = topicSelect.value;
        if (!topic) {
            alert("<?= __('select_topic') ?>");
            return;
        }




        //  фильтры не загружены подгружаем и затем сабмитим
        if (!dynamicFilters.innerHTML.trim()) {
            loadFilters(topic, () => {
                reportForm.action = 'index.php?controller=report&action=index';
                reportForm.submit();
            });
        } else {
            reportForm.action = 'index.php?controller=report&action=index';
            reportForm.submit();
        }
    });





    // Кнопкакс PDF
    if (exportPdfBtn) {
        exportPdfBtn.addEventListener('click', function () {
            reportForm.action = 'index.php?controller=report&action=exportPDF';
            reportForm.submit();
        });
    }
});
</script>
