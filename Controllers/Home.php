<?php
/** @var string $title */
?>

<?= view('templates/header', ['title' => $title]) ?>

<section class="home">
    <h1>Welcome to BINIPOS</h1>

    <p>
        BINIPOS is a basic Point-of-Sale system designed to help manage
        customer and staff account information.
    </p>

    <h2>System Features</h2>

    <div class="features">
        <div class="feature-card">
            <h3>Customer Accounts</h3>

            <p>
                View customer names, email addresses, and phone numbers.
            </p>

            <a href="/customers">View Customers</a>
        </div>

        <div class="feature-card">
            <h3>User Accounts</h3>

            <p>
                View employee usernames, full names, and assigned roles.
            </p>

            <a href="/users">View Users</a>
        </div>

        <div class="feature-card">
            <h3>About the Project</h3>

            <p>
                Learn more about BINIPOS.
            </p>

            <a href="/about">About BINIPOS</a>
        </div>
    </div>
</section>

<style>
    .home {
        padding: 30px 0;
    }

    .home > p {
        max-width: 750px;
        color: #5f6877;
        font-size: 18px;
        line-height: 1.7;
    }

    .features {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-top: 25px;
    }

    .feature-card {
        padding: 25px;
        border: 1px solid #000000;
        border-radius: 10px;
        background: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    .feature-card h3 {
        margin-top: 0;
    }

    .feature-card p {
        min-height: 75px;
        color: #5f6877;
    }

    .feature-card a {
        display: inline-block;
        padding: 10px 16px;
        border-radius: 6px;
        color: white;
        background: #2563eb;
        text-decoration: none;
    }

    .feature-card a:hover {
        background: #1d4ed8;
    }

    @media (max-width: 750px) {
        .features {
            grid-template-columns: 1fr;
        }

        .feature-card p {
            min-height: auto;
        }
    }
</style>

<?= view('templates/footer') ?>
