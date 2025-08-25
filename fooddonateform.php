<?php
include("login.php"); 
if($_SESSION['name']==''){
	header("location: signin.php");
}
// include("login.php"); 
$emailid= $_SESSION['email'];
$connection=mysqli_connect("localhost","root","");
$db=mysqli_select_db($connection,'demo');
if(isset($_POST['submit']))
{
    $foodname=mysqli_real_escape_string($connection, $_POST['foodname']);
    $meal=mysqli_real_escape_string($connection, $_POST['meal']);
    $category=$_POST['image-choice'];
    $quantity=mysqli_real_escape_string($connection, $_POST['quantity']);
    // $email=$_POST['email'];
    $phoneno=mysqli_real_escape_string($connection, $_POST['phoneno']);
    $district=mysqli_real_escape_string($connection, $_POST['district']);
    $address=mysqli_real_escape_string($connection, $_POST['address']);
    $name=mysqli_real_escape_string($connection, $_POST['name']);
  

 



    $query="insert into food_donations(email,food,type,category,phoneno,location,address,name,quantity) values('$emailid','$foodname','$meal','$category','$phoneno','$district','$address','$name','$quantity')";
    $query_run= mysqli_query($connection, $query);
    if($query_run)
    {

        echo '<script type="text/javascript">alert("data saved")</script>';
        header("location:delivery.html");
    }
    else{
        echo '<script type="text/javascript">alert("data not saved")</script>';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodShare - Nourishing Communities, One Meal at a Time</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #780C28;
            --secondary-color: #FFC107;
            --accent-color: #FF5722;
            --text-color: #333333;
            --light-bg: #F5F5F5;
            --dark-bg: #2C3E50;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--light-bg);
            overflow-x: hidden;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            z-index: 1000;
            transition: background-color 0.3s ease, padding 0.3s ease;
        }

        header.scrolled {
            background-color:rgb(238, 130, 238);
            padding: 0.5rem 0;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .nav-links {
            display: flex;
            list-style: none;
        }

        .nav-links li {
            margin-left: 1rem;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            transition: color 0.3s ease, transform 0.3s ease;
            display: inline-block;
        }

        .nav-links a:hover {
            color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .hero {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('1.webp');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 1s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero h1 {
            font-size: 4rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .hero p {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }

        .btn {
            display: inline-block;
            background-color: var(--accent-color);
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .btn:hover {
            background-color: #E64A19;
            transform: translateY(-3px);
            box-shadow: 0 6px 8px rgba(0,0,0,0.15);
        }

        .section {
            padding: 6rem 0;
            position: relative;
            overflow: hidden;
        }

        .section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            opacity: 0.05;
            z-index: -1;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: var(--primary-color);
            position: relative;
            padding-bottom: 1rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background-color: var(--accent-color);
        }

        .impact-stats {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        .stat-item {
            text-align: center;
            margin: 1rem;
            padding: 2rem;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: 200px;
        }

        .stat-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
            line-height: 1;
        }

        .stat-label {
            font-size: 1.1rem;
            color: var(--text-color);
            font-weight: 600;
        }

        .donation-process {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        .process-step {
            text-align: center;
            margin: 1rem;
            flex-basis: calc(25% - 2rem);
            padding: 2rem;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .process-step:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .process-icon {
            font-size: 3rem;
            color: var(--accent-color);
            margin-bottom: 1rem;
        }

        .process-step h3 {
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .testimonials {
            background-color: var(--dark-bg);
            color: white;
        }

        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .testimonial-item {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 2rem;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .testimonial-item:hover {
            transform: translateY(-5px);
        }

        .testimonial-text {
            font-style: italic;
            margin-bottom: 1rem;
        }

        .testimonial-author {
            font-weight: 600;
            color: var(--secondary-color);
        }

        .campaign-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .campaign-item {
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .campaign-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .campaign-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .campaign-item:hover .campaign-image {
            transform: scale(1.05);
        }

        .campaign-content {
            padding: 1.5rem;
        }

        .campaign-title {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
        }

        .campaign-description {
            font-size: 0.9rem;
            margin-bottom: 1rem;
            color: var(--text-color);
        }

        .story-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .story-item {
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .story-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .story-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .story-item:hover .story-image {
            transform: scale(1.05);
        }

        .story-content {
            padding: 1.5rem;
        }

        .story-title {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
        }

        .story-text {
            font-size: 0.9rem;
            color: var(--text-color);
        }

        #donationForm {
            background-color: #ECF0F1;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        #donationForm input[type="text"],
        #donationForm input[type="number"],
        #donationForm input[type="tel"],
        #donationForm select,
        #donationForm textarea {
            color: #2C3E50;
            background-color: #FFFFFF;
        }

        #donationForm input[type="text"]:focus,
        #donationForm input[type="number"]:focus,
        #donationForm input[type="tel"]:focus,
        #donationForm select:focus,
        #donationForm textarea:focus {
            border-color: #3498DB;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        input[type="text"],
        input[type="number"],
        input[type="tel"],
        select,
        textarea {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="tel"]:focus,
        select:focus,
        textarea:focus {
            border-color: var(--secondary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.1);
        }

        .radio-group,
        .checkbox-group {
            display: flex;
            gap: 1rem;
        }

        .faq-section {
            background-color: var(--light-bg);
        }

        .faq-item {
            background-color: white;
            margin-bottom: 1rem;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: box-shadow 0.3s ease;
        }

        .faq-item:hover {
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .faq-question {
            padding: 1.5rem;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.3s ease;
            color: var(--primary-color);
        }

        .faq-question:hover {
            background-color: rgba(76, 175, 80, 0.05);
        }

        .faq-answer {
            padding: 0 1.5rem;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, padding 0.3s ease;
        }

        .faq-item.active .faq-answer {
            padding: 1.5rem;
            max-height: 1000px;
        }

        .faq-item.active .faq-question {
            background-color: var(--primary-color);
            color: white;
        }

        footer {
            background-color: var(--dark-bg);
            color: white;
            text-align: center;
            padding: 2rem 0;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .footer-links {
            display: flex;
            list-style: none;
        }

        .footer-links li {
            margin-left: 1rem;
        }

        .footer-links a {
            color: white;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--secondary-color);
        }

        .social-icons {
            display: flex;
            gap: 1rem;
        }

        .social-icons a {
            color: white;
            font-size: 1.5rem;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .social-icons a:hover {
            color: var(--secondary-color);
            transform: translateY(-3px);
        }

        /* New Sections */
        .featured-campaigns {
            background-color: #fff;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideInLeft {
            from { transform: translateX(-50px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes slideInRight {
            from { transform: translateX(50px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes rotateIn {
            from { transform: rotate(-90deg); opacity: 0; }
            to { transform: rotate(0); opacity: 1; }
        }

        @keyframes scaleIn {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .fade-in {
            animation: fadeIn 1s ease-out;
        }

        .slide-in-left {
            animation: slideInLeft 1s ease-out;
        }

        .slide-in-right {
            animation: slideInRight 1s ease-out;
        }

        .rotate-in {
            animation: rotateIn 1s ease-out;
        }

        .scale-in {
            animation: scaleIn 1s ease-out;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .process-step {
                flex-basis: calc(50% - 2rem);
            }

            .footer-content {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav class="container">
            <div class="logo">FoodShare</div>
            <ul class="nav-links">
                <li><a href="home.html"><b>Home</b></a></li>
                <li><a href="#impact"><b>Impact</b></a></li>
                <li><a href="#process"><b>How It Works</b></a></li>
                <li><a href="#campaigns"><b>Campaigns</b></a></li>
                <li><a href="#stories"><b>Success Stories</b></a></li>
                <li><a href="#donate"><b>Donate</b></a></li>
                <li><a href="#faq"><b>FAQ</b></a></li>
            </ul>
        </nav>
    </header>

    <section id="home" class="hero">
        <div class="hero-content">
            <h1 class="fade-in">Nourishing Communities, One Meal at a Time</h1>
            <p class="fade-in">Join us in the fight against hunger and food waste.</p>
            <a href="#donate" class="btn scale-in">Donate Now</a>
        </div>
    </section>

    <section id="impact" class="section">
        <div class="container">
            <h2 class="section-title fade-in">Our Impact</h2>
            <p class="section-description fade-in">Together, we're making a real difference in our community. Here's what we've achieved so far:</p>
            <div class="impact-stats">
                <div class="stat-item slide-in-left">
                    <div class="stat-number rotate-in">1,000+</div>
                    <div class="stat-label">Meals Donated</div>
                </div>
                <div class="stat-item slide-in-left">
                    <div class="stat-number rotate-in">2,000+</div>
                    <div class="stat-label">People Fed</div>
                </div>
                <div class="stat-item slide-in-right">
                    <div class="stat-number rotate-in">1,000+</div>
                    <div class="stat-label">Active Donors</div>
                </div>
                <div class="stat-item slide-in-right">
                    <div class="stat-number rotate-in">50+</div>
                    <div class="stat-label">Partner NGOs</div>
                </div>
            </div>
        </div>
    </section>

    <section id="process" class="section">
        <div class="container">
            <h2 class="section-title fade-in">How It Works</h2>
            <div class="donation-process">
                <div class="process-step slide-in-left">
                    <div class="process-icon rotate-in"><i class="fas fa-hand-holding-heart"></i></div>
                    <h3>Choose to Donate</h3>
                    <p>Decide to make a difference by sharing your excess food.</p>
                </div>
                <div class="process-step slide-in-left">
                    <div class="process-icon rotate-in"><i class="fas fa-clipboard-list"></i></div>
                    <h3>Fill the Form</h3>
                    <p>Provide details about your donation using our simple form.</p>
                </div>
                <div class="process-step slide-in-right">
                    <div class="process-icon rotate-in"><i class="fas fa-truck"></i></div>
                    <h3>We Collect</h3>
                    <p>Our team or partner NGO will collect the food from your location.</p>
                </div>
                <div class="process-step slide-in-right">
                    <div class="process-icon rotate-in"><i class="fas fa-smile-beam"></i></div>
                    <h3>Feed the Needy</h3>
                    <p>Your donation reaches those who need it most, spreading joy and nourishment.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="campaigns" class="section featured-campaigns">
        <div class="container">
            <h2 class="section-title fade-in">Featured Campaigns</h2>
            <div class="campaign-grid">
                <div class="campaign-item slide-in-left">
                    <img src="img/2.webp" alt="Campaign 1" class="campaign-image">
                    <div class="campaign-content">
                        <h3 class="campaign-title">Feed 100 Families</h3>
                        <p class="campaign-description">Help us provide nutritious meals to 100 underprivileged families for a month.</p>
                        <a href="#" class="btn scale-in">Support Now</a>
                    </div>
                </div>
                <div class="campaign-item slide-in-left">
                    <img src="img/3.webp" alt="Campaign 2" class="campaign-image">
                    <div class="campaign-content">
                        <h3 class="campaign-title">School Lunch Program</h3>
                        <p class="campaign-description">Ensure every child in our local schools gets a healthy lunch every day.</p>
                        <a href="#" class="btn scale-in">Support Now</a>
                    </div>
                </div>
                <div class="campaign-item slide-in-right">
                    <img src="img/4.webp" alt="Campaign 3" class="campaign-image">
                    <div class="campaign-content">
                        <h3 class="campaign-title">Meals for Seniors</h3>
                        <p class="campaign-description">Provide nutritious meals and companionship to elderly individuals in our community.</p>
                        <a href="#" class="btn scale-in">Support Now</a>
                    </div>
                </div>

                <!-- Additional campaign items... -->

            </div>
        </div>
    </section>

    <section id="stories" class="section success-stories">
        <div class="container">
            <h2 class="section-title fade-in">Success Stories</h2>
            <div class="story-grid">
                <div class="story-item slide-in-left">
                    <img src="img/20.webp" alt="Story 1" class="story-image">
                    <div class="story-content">
                        <h3 class="story-title">The Singh Family</h3>
                        <p class="story-text">"FoodShare's support helped us get back on our feet during tough times. We're now able to give back to the community ourselves."</p>
                    </div>
                </div>
                <div class="story-item slide-in-left">
                    <img src="img/21.webp" alt="Story 2" class="story-image">
                    <div class="story-content">
                        <h3 class="story-title">Spice & Soul Restaurant</h3>
                        <p class="story-text">"Partnering with FoodShare has allowed us to reduce food waste and make a positive impact in our neighborhood."</p>
                    </div>
                </div>
                <div class="story-item slide-in-right">
                    <img src="img/22.webp" alt="Story 3" class="story-image">
                    <div class="story-content">
                        <h3 class="story-title">Sarah, Volunteer</h3>
                        <p class="story-text">"Volunteering with FoodShare has opened my eyes to the power of community. It's incredible to see how we can make a difference together."</p>
                    </div>
                </div>

                <!-- Additional story items... -->

            </div>
        </div>
    </section>

    <section id="donate" class="section">
        <div class="container">
            <h2 class="section-title fade-in">Donate Food</h2>
            <form action="" method="post" id="donationForm">
                <p class="logo">Food <b style="color: #06C167; ">Donate</b></p>
                
                <div class="form-group">
                    <label for="foodname">Food Name:</label>
                    <input type="text" id="foodname" name="foodname" required/>
                </div>
                
                <div class="form-group">
                    <label>Meal type:</label>
                    <div class="radio-group">
                        <input type="radio" name="meal" id="veg" value="veg" required/>
                        <label for="veg">Veg</label>
                        <input type="radio" name="meal" id="Non-veg" value="Non-veg" />
                        <label for="Non-veg">Non-veg</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Select the Category:</label>
                    <div class="image-radio-group">
                        <input type="radio" id="raw-food" name="image-choice" value="raw-food">
                        <label for="raw-food">
                            <p> Raw Food</p>
                        </label>
                        <input type="radio" id="cooked-food" name="image-choice" value="cooked-food" checked>
                        <label for="cooked-food">
                            <p> Cooked  Food</p>
                        </label>
                        <input type="radio" id="packed-food" name="image-choice" value="packed-food">
                        <label for="packed-food">
                         <p> Packed  Food</p>
                                                    </label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="quantity">Please Enter Quantity: (number of person /kg)</label>
                    <input type="text" id="quantity" name="quantity" required/>
                </div>
                
                <h3>Contact Details</h3>
                
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo"". $_SESSION['name'] ;?>" required/>
                </div>
                
                <div class="form-group">
                    <label for="phoneno">Please Enter Phone No:</label>
                    <input type="text" id="phoneno" name="phoneno" maxlength="10" pattern="[0-9]{10}" required />
                </div>
                
                <div class="form-group">
                    <label for="district">Select Area Name For Accept the Food:</label>
                    <select id="district" name="district">
                        <option value="andheri">Andheri</option>
                        <option value="marine drive">Marine Drive</option>
                        <option value="bandra">Bandra</option>
                        <option value="juhu">Juhu</option>
                        <option value="pawai">Pawai</option>
                        <option value="goregaon">Goregaon</option>
                        <option value="malad">Malad</option>
                        <option value="sakinaka">Sakinaka</option>
                        <option value="kurla">Kurla</option>
                        <option value="chakala">Chakala</option>
                        <option value="dadar">Dadar</option>
                        <option value="borivali">Borivali</option>
                        <option value="vashi">Vashi</option>
                        <option value="chembur">Chembur</option>
                        <option value="lower parel">Lower Parel</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="address">Please Enter Delivery Address:</label>
                    <input type="text" id="address" name="address" required/>
                </div>

                <div class="form-group">
                    <label for="ngo" style="color: #34495E;">Choose NGO:</label>
                    <select id="ngo" name="ngo" required style="color: #2980B9;">
                        <option value="">Select an NGO</option>
                        <option value="Feeding India">Feeding India</option>
                        <option value="Robin Hood Army">Robin Hood Army</option>
                        <option value="No Food Waste">No Food Waste</option>
                        <option value="Roti Bank">Roti Bank</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" name="submit" class="btn">Submit</button>
                </div>
            </form>
        </div>
    </section>

    <section id="faq" class="section faq-section">
        <div class="container">
            <h2 class="section-title fade-in">Frequently Asked Questions</h2>
            <div class="faq-list">
                <div class="faq-item slide-in-left">
                    <div class="faq-question">What types of food can I donate? <i class="fas fa-chevron-down"></i></div>
                    <div class="faq-answer">You can donate any type of edible food that is not expired. This includes cooked meals, raw ingredients, packaged foods, and fresh produce. We especially encourage donations of nutritious, non-perishable items.</div>
                </div>
                <div class="faq-item slide-in-left">
                    <div class="faq-question">How do I ensure the food I'm donating is safe? <i class="fas fa-chevron-down"></i></div>
                    <div class="faq-answer">Ensure that the food is properly stored and handled before donation. For cooked food, cool it quickly and store it in the refrigerator. Package items securely and label them with the contents and date of preparation.</div>
                </div>
                <div class="faq-item slide-in-right">
                    <div class="faq-question">Can I choose where my donation goes? <i class="fas fa-chevron-down"></i></div>
                    <div class="faq-answer">Yes, you can select a preferred NGO partner from our list when filling out the donation form. However, we may redirect donations based on urgent needs and logistical considerations.</div>
                </div>
                <div class="faq-item slide-in-right">
                    <div class="faq-question">How quickly will my donation be collected? <i class="fas fa-chevron-down"></i></div>
                    <div class="faq-answer">We strive to collect donations as quickly as possible, usually within 24 hours of submission. For perishable items, we prioritize faster collection times.</div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container footer-content">
            <p>&copy; 2023 FoodShare. All rights reserved.</p>
            <ul class="footer-links">
                <li><a href="#home">Home</a></li>
                <li><a href="#impact">Impact</a></li>
                <li><a href="#process">How It Works</a></li>
                <li><a href="#donate">Donate</a></li>
                <li><a href="#faq">FAQ</a></li>
            </ul>
            <div class="social-icons">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
            </div>
        </div>
    </footer>

    <script>
    // FAQ Accordion
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
        item.addEventListener('click', () => {
            item.classList.toggle('active');
        });
    });

    // Form Validation
    const form = document.getElementById('donationForm');
    form.addEventListener('submit', (e) => {
        if (!validateForm()) {
            e.preventDefault();
        }
    });

    function validateForm() {
        let isValid = true;
        const requiredFields = form.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('error');
            } else {
                field.classList.remove('error');
            }
        });

        // Check if a food category is selected
        const categoryRadios = form.querySelectorAll('input[name="image-choice"]');
        let categoryChecked = false;
        categoryRadios.forEach(radio => {
            if (radio.checked) categoryChecked = true;
        });
        if (!categoryChecked) {
            isValid = false;
            alert('Please select a food category');
        }

        return isValid;
    }

    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.textContent = message;
        notification.className = `notification ${type}`;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    // Scroll effect for header
    window.addEventListener('scroll', () => {
        const header = document.querySelector('header');
        if (window.scrollY > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // Intersection Observer for animations
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    const animatedElements = document.querySelectorAll('.fade-in, .slide-in-left, .slide-in-right, .rotate-in, .scale-in');
    animatedElements.forEach(el => observer.observe(el));
</script>
</body>
</html>

