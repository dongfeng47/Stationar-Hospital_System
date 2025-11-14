<div class="dashboard statistician-dashboard">
    <h2><?= __('welcome_statistician', ['username' => htmlspecialchars($username)]) ?></h2>
    <p><?= __('statistician_tools') ?></p>
    <ul class="dashboard-links">
    <li><a href=""><?= __('statistical_reports') ?></a></li>
<li><a href=""><?= __('settings') ?></a></li>
<li><a href=""><?= __('diagnoses') ?></a></li>
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
    background-color: #ffffff;
    color: #000000;
    max-width: 600px;
    padding: 30px;
    margin: 40px; 
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.dashboard h2 {
    font-size: 24px;
    margin-bottom: 10px;
}

.dashboard p {
    font-size: 16px;
    margin-bottom: 25px;
    color: #333333;
}

.dashboard-links {
    list-style: none;
    padding: 0;
}

.dashboard-links li {
    margin-bottom: 15px;
}

.dashboard-links a {
    text-decoration: none;
    font-size: 18px;
    color: #000000;
    padding: 8px 12px;
    display: inline-block;
    transition: background-color 0.2s, color 0.2s;
    border-radius: 6px;
}

.dashboard-links a:hover {
    background-color: #f0f0f0;
}
</style>
