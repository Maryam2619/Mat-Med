<?php
$conn = mysqli_connect("localhost", "root", "", "materiamedica");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

include('../layout/header.php');


// Fetch category names and remedy counts
$query = "
    SELECT remedy_categories.Category_ID, remedy_categories.Category_Name, 
           COUNT(remedies.Remedy_ID) AS Remedy_Count 
    FROM remedy_categories
    LEFT JOIN remedies 
    ON remedy_categories.Category_ID = remedies.Category_ID
    GROUP BY remedy_categories.Category_ID";
$result = $conn->query($query);

// Store the data in an array
$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

// Now manually assign image paths based on Category_ID
foreach ($categories as $key => $category) {
    switch ($category['Category_ID']) {
        case 1:
            $categories[$key]['Image_Path'] = '../images/plant.jpg';
            break;
        case 2:
            $categories[$key]['Image_Path'] = '../images/plant.jpg';
            break;
        case 3:
            $categories[$key]['Image_Path'] = '../images/chemical.jpg';
            break;
        case 4:
            $categories[$key]['Image_Path'] = '../images/mineral.jpg';
            break;
        default:
            $categories[$key]['Image_Path'] = '../images/plant.jpg'; 
    }
}

?>

      <!-- start -->
    <div class="s130">
      <form>
        <div class="col-lg-12 mt-5">
            <h3>Discover Natural Healing with Homeopathy</h3>
        </div>
        <div class="inner-form mt-3">
          <div class="input-field first-wrap">
            <div class="svg-wrapper">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
              </svg>
            </div>
            <div class="search-wrapper">
            <input id="search"  type="text" placeholder="What are you looking for?">
            <div id="suggestions"></div>
            </div>
          </div>
          <div class="input-field second-wrap">
            <button id="searchBtn" class="btn-search" type="button">SEARCH</button>
          </div>
        </div>
        <span class="info">Find natural remedies, explore a trusted homeopathy database, and take control of your wellness.</span>
      </form>
    </div>

    <!-- Category Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h1 class="mb-3">Explore Remedies by Category</h1>
                <p>Discover homeopathic remedies categorized for easy access. Find plant-based, mineral-based, and other natural solutions tailored to your needs.</p>
            </div>
            <div class="row g-4">
            <?php foreach ($categories as $category): ?>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">                
                    <a class="cat-item d-block bg-light text-center rounded p-3" href="remedies.php?category=<?= $category['Category_ID'] ?>">
                        <div class="rounded p-4">
                            <div class="icon mb-3">
                            <!-- <i class="fa-solid fa-seedling"></i> -->
                                <img class="img-fluid" src="<?= $category['Image_Path'] ?>" alt="<?= htmlspecialchars($category['Category_Name']) ?>">
                                <!-- <img class="img-fluid" src="peter-mammitzsch-xo_HZcRbX0A-unsplash (1).jpg" alt="Icon"> -->
                            </div>
                            <h6><?= htmlspecialchars($category['Category_Name']) ?></h6>
                    <span><?= $category['Remedy_Count'] ?? 0; ?> Remedies</span>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!-- Category End -->

     <!-- About Start -->
     <div class="container-xxl discover py-5">
        <div class="container" id="about">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="about-img position-relative overflow-hidden p-5 pe-0">
                        <img class="img-fluid w-100" src="../images/homeo.jpg">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="mb-4">Place to Discover the Right Remedy</h1>
                    <p class="mb-4">Discover the power of homeopathy with natural remedies tailored to your needs. Explore safe, effective treatments backed by traditional wisdom and expert knowledge.</p>
                    <p><i class="fa fa-check text-primary me-3"></i>Personalized remedy recommendations</p>
                    <p><i class="fa fa-check text-primary me-3"></i>Comprehensive remedy database</p>
                    <p><i class="fa fa-check text-primary me-3"></i>Trusted, expert-backed information</p>
                    <a class="btn btn-primary py-3 px-5 mt-3" href="remedies.php">Read More</a>

                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <section class="how-it-works text-center py-5">
        <div class="container">
          <h2 class="mb-4">How It Works</h2>
          <p class="mb-5">Find remedies in just three easy steps!</p>
      
          <div class="row g-4">
            <!-- Step 1 -->
            <div class="col-md-4">
              <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                  <i class="fa fa-search text-primary mb-3" style="font-size: 40px;"></i>
                  <h5 class="card-title">Search for Symptoms</h5>
                  <p class="card-text">Type your symptom or remedy name to find relevant treatments.</p>
                </div>
              </div>
            </div>
      
            <!-- Step 2 -->
            <div class="col-md-4">
              <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                  <i class="fa fa-book text-success mb-3" style="font-size: 40px;"></i>
                  <h5 class="card-title">Explore Detailed Info</h5>
                  <p class="card-text">View remedy details, including symptoms treated and dosage.</p>
                </div>
              </div>
            </div>
      
            <!-- Step 3 -->
            <div class="col-md-4">
              <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                  <i class="fa fa-check-circle text-danger mb-3" style="font-size: 40px;"></i>
                  <h5 class="card-title">Find Recommended Treatment</h5>
                  <p class="card-text">Get trusted homeopathic treatment suggestions.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      
      
    <div class="app-component-content d-flex align-items-center justify-content-center" id="articles">
        <section data-bs-version="5.1" class="features6 careerm5 cid-uERVPb101a" mbr-class2="this | fakeFilter uname__1 _params.fullScreen _params.bg.parallax" mbr-id="_anchor" id="blog-1-uERVPb101a" data-rv-view="60">

    

        <div class="mbr-fallback-image disabled" mbr-if="this | fakeFilter uname__23 _params.bg.type" data-app-remove-it="true" style="display: none;"></div>
        <div class="mbr-overlay" mbr-if="this | fakeFilter uname__24 _params.overlay _params.bg.type" mbr-style2="this | fakeFilter uname__25 _params.overlayOpacity _params.overlayColor" data-app-remove-it="true" style="display: none; opacity: 0.3; background-color: rgb(0, 0, 0);">
        </div>
    
        <div mbr-class2="this | fakeFilter uname__26 _params.fullWidth _params.fullWidth" class="container">
            <div class="row" mbr-class2="this | fakeFilter uname__27 _params.reverseContent">
                <div class="col-12">
                    <div class="title-wrapper">
                        <h2 class="mbr-section-title mbr-fonts-style text-center display-6" data-app-selector=".mbr-section-title, .mbr-section-btn" mbr-if="this | fakeFilter uname__30 _params.showTitle" mbr-class-var="uname__28" mbr-on-change-theme-style="uname__29" data-app-edit="content" mbr-static-html="uname__31" mbr-content-edit="uname__31" data-app-placeholder="Type Text" mbr-on-change-component-node="uname__32" data-class-var="display-2">Latest Insights</h2>
                    </div>
                </div>
                <div class="col-12 col-lg-4 item features-image">
                    <a href="https://www.betterhealth.vic.gov.au/health/conditionsandtreatments/homeopathy">
                        <div class="item-wrapper">
                            <div class="item-img">
                                <img src="../images/laura-olsen-lg9QrSa8VaQ-unsplash.jpg" alt="Mobirise Website Builder" data-slide-to="0" data-bs-slide-to="0" mbr-media="uname__33" mbr-media-simple="true" mbr-on-click="uname__34" media-simple="true">
                                <span class="mbr-iconfont mbr-iconfont-btn mobi-mbri-play mobi-mbri" mbr-if="this | fakeFilter uname__37 _params.showIcon" mbr-media="uname__35" mbr-media-simple="true" mbr-on-click="uname__36" data-app-remove-it="true" media-simple="true" style="display: none;"></span>
                            </div>
                        </div>
                        <div class="item-content">
                            <div class="item-time" mbr-if="this | fakeFilter uname__38 _params.showTime" data-app-remove-it="true" style="display: none;">
                                <div class="item-time-wrap">
                                    <span class="icon-time mbr-iconfont mbr-iconfont-btn mbrib-video" mbr-media="uname__39" mbr-media-simple="true" mbr-on-click="uname__40" media-simple="true"></span>
                                    <p class="mbr-time mbr-fonts-style display-4" data-app-selector=".mbr-time, .icon-time, .item-time" mbr-class-var="uname__41" mbr-on-change-theme-style="uname__42" data-app-edit="content" mbr-static-html="uname__43" mbr-content-edit="uname__43" data-app-placeholder="Type Text" mbr-on-change-component-node="uname__44" data-class-var="display-4">
                                        9:00
                                    </p>
                                </div>
                            </div>
                            <h3 class="mbr-card-title mbr-fonts-style" data-app-selector=".mbr-card-title" mbr-if="this | fakeFilter uname__47 _params.showTitle" mbr-class-var="uname__45" mbr-on-change-theme-style="uname__46" data-app-edit="content" mbr-static-html="uname__48" mbr-content-edit="uname__48" data-app-placeholder="Type Text" mbr-on-change-component-node="uname__49" data-class-var="display-5">Homeopathy: The Natural Healer</h3>
                            <p class="mbr-desc mbr-fonts-style" data-app-selector=".mbr-desc" mbr-if="this | fakeFilter uname__52 _params.showDesc" mbr-class-var="uname__50" mbr-on-change-theme-style="uname__51" data-app-edit="content" mbr-static-html="uname__53" mbr-content-edit="uname__53" data-app-placeholder="Type Text" mbr-on-change-component-node="uname__54" data-class-var="display-4">Discover how homeopathy can change your health game.</p>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-lg-4 card item features-image">
                    <a href="https://gmcdhcc.com/blogs/myths-of-homeopathy-that-most-people-dont-know/">
                        <div class="item-wrapper">
                            <div class="item-img">
                                <img src="../images/mineral.jpg" alt="Mobirise Website Builder" data-slide-to="1" data-bs-slide-to="1" mbr-media="uname__55" mbr-media-simple="true" mbr-on-click="uname__56" media-simple="true">
                                <span class="mbr-iconfont mbr-iconfont-btn mobi-mbri-play mobi-mbri" mbr-if="this | fakeFilter uname__59 _params.showIcon" mbr-media="uname__57" mbr-media-simple="true" mbr-on-click="uname__58" data-app-remove-it="true" media-simple="true" style="display: none;"></span>
                            </div>
                        </div>
                        <div class="item-content">
                            <div class="item-time" mbr-if="this | fakeFilter uname__60 _params.showTime" data-app-remove-it="true" style="display: none;">
                                <div class="item-time-wrap">
                                    <span class=" icon-time mbr-iconfont mbr-iconfont-btn mbrib-video" mbr-media="uname__61" mbr-media-simple="true" mbr-on-click="uname__62" media-simple="true"></span>
                                    <p class="mbr-time mbr-fonts-style display-4" data-app-selector=".mbr-time, .icon-time, .item-time" mbr-class-var="uname__63" mbr-on-change-theme-style="uname__64" data-app-edit="content" mbr-static-html="uname__65" mbr-content-edit="uname__65" data-app-placeholder="Type Text" mbr-on-change-component-node="uname__66" data-class-var="display-4">
                                        10:00
                                    </p>
                                </div>
                            </div>
                            <h3 class="mbr-card-title mbr-fonts-style" data-app-selector=".mbr-card-title" mbr-if="this | fakeFilter uname__69 _params.showTitle" mbr-class-var="uname__67" mbr-on-change-theme-style="uname__68" data-app-edit="content" mbr-static-html="uname__70" mbr-content-edit="uname__70" data-app-placeholder="Type Text" mbr-on-change-component-node="uname__71" data-class-var="display-5">Common Homeopathy Myths</h3>
                            <p class="mbr-desc mbr-fonts-style" data-app-selector=".mbr-desc" mbr-if="this | fakeFilter uname__74 _params.showDesc" mbr-class-var="uname__72" mbr-on-change-theme-style="uname__73" data-app-edit="content" mbr-static-html="uname__75" mbr-content-edit="uname__75" data-app-placeholder="Type Text" mbr-on-change-component-node="uname__76" data-class-var="display-4">Busting myths that keep you from healing.</p>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-lg-4 item features-image">
                    <a href="https://karenleadbeater.co.uk/eight-homeopathic-remedies-for-acute-tiredness-and-fatigue/">
                        <div class="item-wrapper">
                            <div class="item-img">
                                <img src="../images/chemical.jpg" alt="Mobirise Website Builder" data-slide-to="2" data-bs-slide-to="2" mbr-media="uname__77" mbr-media-simple="true" mbr-on-click="uname__78" media-simple="true">
                                <span class="mbr-iconfont mbr-iconfont-btn mobi-mbri-play mobi-mbri" mbr-if="this | fakeFilter uname__81 _params.showIcon" mbr-media="uname__79" mbr-media-simple="true" mbr-on-click="uname__80" data-app-remove-it="true" media-simple="true" style="display: none;"></span>
                            </div>
                        </div>
                        <div class="item-content">
                            <div class="item-time" mbr-if="this | fakeFilter uname__82 _params.showTime" data-app-remove-it="true" style="display: none;">
                                <div class="item-time-wrap">
                                    <span class="icon-time mbr-iconfont mbr-iconfont-btn mbrib-video" mbr-media="uname__83" mbr-media-simple="true" mbr-on-click="uname__84" media-simple="true"></span>
                                    <p class="mbr-time mbr-fonts-style display-4" data-app-selector=".mbr-time, .icon-time, .item-time" mbr-class-var="uname__85" mbr-on-change-theme-style="uname__86" data-app-edit="content" mbr-static-html="uname__87" mbr-content-edit="uname__87" data-app-placeholder="Type Text" mbr-on-change-component-node="uname__88" data-class-var="display-4">
                                        12:30
                                    </p>
                                </div>
                            </div>
                            <h3 class="mbr-card-title mbr-fonts-style" data-app-selector=".mbr-card-title" mbr-if="this | fakeFilter uname__91 _params.showTitle" mbr-class-var="uname__89" mbr-on-change-theme-style="uname__90" data-app-edit="content" mbr-static-html="uname__92" mbr-content-edit="uname__92" data-app-placeholder="Type Text" mbr-on-change-component-node="uname__93" data-class-var="display-5">Homeopathy for Busy Lives</h3>
                            <p class="mbr-desc mbr-fonts-style" data-app-selector=".mbr-desc" mbr-if="this | fakeFilter uname__96 _params.showDesc" mbr-class-var="uname__94" mbr-on-change-theme-style="uname__95" data-app-edit="content" mbr-static-html="uname__97" mbr-content-edit="uname__97" data-app-placeholder="Type Text" mbr-on-change-component-node="uname__98" data-class-var="display-4">Quick remedies for your hectic schedule.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section></div>


    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="mb-4">Benefits of Homeopathy</h1>
                    <p class="mb-4">Homeopathy is a natural and effective way to restore balance and health. Here’s why millions trust it:</p>
                    <p><i class="fa fa-check text-primary me-3"></i>100% Natural & Safe – No side effects</p>
                    <p><i class="fa fa-check text-primary me-3"></i>Treats the root cause, not just symptoms</p>
                    <p><i class="fa fa-check text-primary me-3"></i> Personalized treatment for every individual</p>
                    <p><i class="fa fa-check text-primary me-3"></i>Suitable for all ages, including infants & elderly</p>
                    <p><i class="fa fa-check text-primary me-3"></i>Boosts body's natural healing power</p>
                    <p><i class="fa fa-check text-primary me-3"></i>Helps with chronic & acute conditions</p>
                    <a class="btn btn-primary py-3 px-5 mt-3" href="remedies.php">Read More</a>

                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="about-img position-relative overflow-hidden p-5 pe-0">
                        <img class="img-fluid w-100" src="../images/homeo.jpg">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

     <!--Principle-->    
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-gradient">📖 Principles of Homeopathy</h2>
            <p class="text-muted">Core fundamentals that guide homeopathic treatment.</p>
        </div>
    
        <div class="row">
            <div class="col-lg-6">
                <div class="principle-box">
                    <h5>🔄 The Law of Similars</h5>
                    <p>“Like cures like” – A substance that causes symptoms in a healthy person can treat similar symptoms in a sick person.</p>
                </div>
    
                <div class="principle-box">
                    <h5>💧 Minimum Dose</h5>
                    <p>Using the smallest possible dose to trigger the body’s natural healing response without side effects.</p>
                </div>
            </div>
    
            <div class="col-lg-6">
                <div class="principle-box">
                    <h5>🌱 Individualized Treatment</h5>
                    <p>Every patient is unique, and homeopathic treatments are personalized based on physical and emotional factors.</p>
                </div>
    
                <div class="principle-box">
                    <h5>🌀 Vital Force & Holistic Healing</h5>
                    <p>Healing is not just about symptoms but treating the body, mind, and energy balance.</p>
                </div>
            </div>
        </div>
    </div>


    <section id="faq" class="faq-section py-5">
        <div class="container">
            <div class="row align-items-center">
                <!-- Left Side - FAQ Title -->
                <div class="col-lg-4 text-center text-lg-start">
                    <div class="faq-title">
                        <h2 class="fw-bold">❓ Frequently Asked Questions</h2>
                        <p class="text-muted">
                            Find answers to common questions about homeopathy and how our platform works.
                        </p>
                        <img src="../images/homeo.jpg" alt="FAQs" class="faq-image img-fluid mt-3">
                    </div>
                </div>
    
                <!-- Right Side - FAQ Accordion -->
                <div class="col-lg-8">
                    <div class="accordion" id="faqAccordion">
                        <!-- FAQ 1 -->
                        <div class="accordion-item">
                            <h5 class="accordion-header">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    <span class="icon">+</span> What is homeopathy?
                                </button>
                            </h5>
                            <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Homeopathy is a natural form of medicine that uses highly diluted substances to stimulate the body's healing process.
                                </div>
                            </div>
                        </div>
    
                        <!-- FAQ 2 -->
                        <div class="accordion-item">
                            <h5 class="accordion-header">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    <span class="icon">+</span> Is homeopathy safe to use?
                                </button>
                            </h5>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes, homeopathic remedies are generally safe, non-toxic, and do not cause harmful side effects.
                                </div>
                            </div>
                        </div>
    
                        <!-- FAQ 3 -->
                        <div class="accordion-item">
                            <h5 class="accordion-header">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    <span class="icon">+</span> Can I use homeopathy with conventional medicine?
                                </button>
                            </h5>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Homeopathy can often be used alongside conventional treatments, but consulting a qualified practitioner is recommended.
                                </div>
                            </div>
                        </div>
    
                        <!-- FAQ 4 -->
                        <div class="accordion-item">
                            <h5 class="accordion-header">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    <span class="icon">+</span> How long does homeopathy take to work?
                                </button>
                            </h5>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    The effectiveness varies. Acute conditions may improve quickly, while chronic issues might take longer.
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- Right Side End -->
            </div>
        </div>
    </section>

    <?php include '../layout/footer.php'; ?>
    
    

    <script>
        const searchInput = document.getElementById('search');
        const suggestionBox = document.getElementById('suggestions');
        const searchBtn = document.getElementById('searchBtn');

    searchBtn.addEventListener('click', () => {
        const query = searchInput.value.trim();
        if (query.length > 0) {
            window.location.href = `search.php?q=${encodeURIComponent(query)}`;
        }
    });

                // Helper function to highlight query text
        function highlightMatch(text, query) {
            const regex = new RegExp(`(${query})`, 'gi');
            return text.replace(regex, '<mark style="background-color: yellow;  padding: 0 2px; border-radius: 3px; ">$1</mark>');
        }
    
        searchInput.addEventListener('input', function () {
            let query = this.value.trim();
            if (query.length > 1) {
                fetch(`http://localhost/test/pages/search_suggestion.php?q=${encodeURIComponent(query)}`)

                // fetch(`search_suggestion.php?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        suggestionBox.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(item => {
                                let div = document.createElement('div');

                                        // Highlight query in name, description, and symptoms
                                const highlightedName = highlightMatch(item.name, query);
                                const highlightedDesp = highlightMatch(item.desp, query);
                                const highlightedSymptoms = highlightMatch(item.symptoms, query);

                                div.innerHTML = `
                            <strong>${highlightedName}</strong><br>
                            <em>${highlightedDesp}</em><br>
                            <small><b>Symptoms:</b> ${highlightedSymptoms}</small>
                        `;
                                // div.textContent = item.name;
                                div.classList.add('suggestion-item');
                                div.onclick = function () {
                                    window.location.href = `remedy_detail.php?id=${item.id}`;
                                };
                                suggestionBox.appendChild(div);
                            });
                        } else {
                            suggestionBox.innerHTML = '<div class="suggestion-item">No suggestions found</div>';
                        }
                    });
            } else {
                suggestionBox.innerHTML = '';
            }
        });
    
        // Hide suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target)) {
                suggestionBox.innerHTML = '';
            }
        });
    </script>

    <script type="text/javascript" async="" src="https://www.google-analytics.com/analytics.js"></script>
  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- <script src="js/extention/choices.js"></script> -->
<script>
(function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="phbPBOPVwbt-YlFbr9Ovv";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
</script>
</body><grammarly-desktop-integration data-grammarly-shadow-root="true"></grammarly-desktop-integration></html>