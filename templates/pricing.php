<?php
$pageTitle = 'Pricing';
include __DIR__ . '/layouts/header.php';
?>

<style>
.pricing-wrapper {
    max-width: 900px;
    margin: 60px auto;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 28px rgba(33,52,96,0.12), 0 1.5px 6px rgba(33,52,96,0.07);
    padding: 44px 32px 32px 32px;
    text-align: center;
}
@media (max-width: 700px) {
    .pricing-wrapper { padding: 24px 8px; }
}
.pricing-wrapper h1 {
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 2rem;
    color: #213460;
}
.pricing-cards {
    display: flex;
    gap: 1.5rem;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;
}
.pricing-card {
    flex: 1 1 260px;
    background: #fafafa;
    border-radius: 14px;
    box-shadow: 0 2px 12px rgba(33,52,96,0.08);
    padding: 32px 26px 28px 26px;
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: box-shadow 0.18s;
    border: 2px solid #fff;
    min-width: 250px;
    max-width: 320px;
}
.pricing-card.featured {
    border: 2.5px solid #ffd814;
    background: #fffbe7;
    box-shadow: 0 4px 16px rgba(255,216,20,0.11);
    position: relative;
}
.pricing-card .badge {
    position: absolute;
    top: -18px;
    left: 50%;
    transform: translateX(-50%);
    background: #ffd814;
    color: #876800;
    font-weight: 700;
    border-radius: 20px;
    padding: 4px 18px;
    font-size: 0.98rem;
    box-shadow: 0 1px 6px rgba(255,216,20,0.11);
}
.pricing-card h2 {
    font-size: 1.35rem;
    font-weight: 700;
    color: #213460;
    margin-bottom: 0.7rem;
}
.pricing-card .price {
    font-size: 2.1rem;
    font-weight: 800;
    color: #ffd814;
    margin-bottom: 0.5rem;
}
.pricing-card .desc {
    color: #7a879a;
    margin-bottom: 1rem;
    font-size: 1.03rem;
}
.pricing-card ul {
    list-style: none;
    margin: 0 0 1.15rem 0;
    padding: 0;
    text-align: left;
}
.pricing-card ul li {
    margin: 0.4em 0;
    font-size: 1rem;
    color: #213460;
}
.pricing-card .btn-primary {
    background: linear-gradient(90deg, #ffd814 60%, #ffecb3 100%);
    border: none;
    border-radius: 50px;
    color: #876800;
    font-weight: 600;
    padding: 10px 28px;
    text-decoration: none;
    transition: background 0.18s;
    display: inline-block;
    margin-top: 0.7rem;
}
.pricing-card .btn-primary:hover {
    background: #ffe484;
    color: #213460;
}
.pricing-info {
    color: #7a879a;
    font-size: 1.01rem;
    margin-top: 2.3rem;
}
</style>

<div class="pricing-wrapper">
    <h1>Pricing & Packages</h1>
    <div class="pricing-cards">
        <div class="pricing-card">
            <h2>Starter</h2>
            <div class="price">Free</div>
            <div class="desc">Get started and publish up to 10 posts per month.</div>
            <ul>
                <li>✔️ 10 posts/month</li>
                <li>✔️ Basic support</li>
                <li>✔️ Community access</li>
            </ul>
            <span class="btn-primary disabled" style="pointer-events:none;opacity:0.6;">Current</span>
        </div>
        <div class="pricing-card featured">
            <span class="badge">Most Popular</span>
            <h2>Pro</h2>
            <div class="price">$9<span style="font-size:1.1rem;font-weight:500;">/mo</span></div>
            <div class="desc">For regular writers and teams who need more exposure.</div>
            <ul>
                <li>✔️ 100 posts/month</li>
                <li>✔️ Priority support</li>
                <li>✔️ Post analytics</li>
                <li>✔️ Highlighted in feeds</li>
            </ul>
            <a href="/subscribe/pro" class="btn-primary">Upgrade to Pro</a>
        </div>
        <div class="pricing-card">
            <h2>Unlimited</h2>
            <div class="price">$29<span style="font-size:1.1rem;font-weight:500;">/mo</span></div>
            <div class="desc">For agencies, publishers or those who never want limits.</div>
            <ul>
                <li>✔️ Unlimited posts</li>
                <li>✔️ Premium support</li>
                <li>✔️ Advanced analytics</li>
                <li>✔️ Team management</li>
            </ul>
            <a href="/subscribe/unlimited" class="btn-primary">Go Unlimited</a>
        </div>
    </div>
    <div class="pricing-info">
        All plans can be cancelled anytime. <br>
        For custom needs or enterprise plans, <a href="/contact">contact us</a>.
    </div>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>