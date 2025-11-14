<div class="dashboard doctor-dashboard">
    <h2><?= __('welcome_doctor', ['username' => htmlspecialchars($username)]) ?></h2>
    <p><?= __('doctor_tools') ?></p>
    <ul class="dashboard-links">
 <li><?= __('patients') ?></li>
<li><?= __('hospitalizations') ?></li>
 <li><?= __('procedures') ?></li>
 <li><?= __('diagnoses') ?></li>
        <li><?= __('settings') ?></li>
    </ul>
</div>

<style>
body {
    background-color: #ffffff;
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.dashboard {
    color: #000000;
    max-width: 600px;
    padding: 20px 40px; 
}

.dashboard h2 {
    font-size: 24px;
    margin-bottom: 10px;
}

.dashboard p {
    font-size: 16px;
    margin-bottom: 20px;
    color: #333333;
}

.dashboard-links {
    list-style: none;
    padding: 0;
}

.dashboard-links li {
    font-size: 18px;
    margin-bottom: 12px;
}
</style>
