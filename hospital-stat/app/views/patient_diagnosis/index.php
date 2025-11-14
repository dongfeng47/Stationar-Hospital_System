<h2>Диагнозы пациента</h2>
<a href="index.php?controller=patient&action=index">Назад к пациентам</a>
<table border="1">
<tr>
<th>DiagnosisId</th>
<th>DiagnosisName</th>
<th>Действия</th> </tr>
<?php foreach($diagnoses as $d): ?>
    <tr>
 <td><?= $d['DiagnosisId'] ?></td>
<td><?= $d['DiagnosisName'] ?></td>
<td>
 <a href="index.php?controller=patientdiagnosis&action=removeDiagnosis&patientId=<?= $_GET['id'] ?>&diagnosisId=<?= $d['DiagnosisId'] ?>">Удалить</a>
</td>
</tr>
<?php endforeach; ?>
</table>

<h3>Добавить диагноз</h3>
<form action="index.php?controller=patientdiagnosis&action=addDiagnosis" method="post">
    <input type="hidden" name="patientId" value="<?= $_GET['id'] ?>">
    <label>Диагноз:</label>
    <input type="number" name="diagnosisId">
    <button type="submit">Добавить</button>
</form>
