<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Kıraç.ai</title>
  <link rel="stylesheet" href="https://public.codepenassets.com/css/normalize-5.0.0.min.css">
  <link rel="stylesheet" href="./css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
  <div class="video-bg">
    <video width="320" height="240" autoplay loop muted>
      <source src="https://assets.codepen.io/3364143/7btrrd.mp4" type="video/mp4">
      Your browser does not support the video tag.
    </video>
  </div>
  
  <div class="app">
    <center><image src="./assets/kirac-bist-logo.png" width="500px" style="z-index: 1000; position: relative;"></image></center>
    <div class="header">
      <div class="menu-circle" style="user-select: none;">
        Kıraç.ai
      </div>
      <div class="search-bar">
        <input type="text" placeholder="Ara..." style="user-select: none;">
      </div>
      <div class="header-profile">
        <div class="dark-light">
          <svg width="100%" height="100%" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path d="M21.9548 12.9564C20.5779 15.3717 17.9791 17.0001 15 17.0001C10.5817 17.0001 7 13.4184 7 9.00008C7 6.02072 8.62867 3.42175 11.0443 2.04492C5.96975 2.52607 2 6.79936 2 11.9998C2 17.5227 6.47715 21.9998 12 21.9998C17.2002 21.9998 21.4733 18.0305 21.9548 12.9564Z" stroke="currentColor" stroke-width="0" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <div class="dropdown dark-light">
          <button class="dropdown-toggle">
            <svg width="100%" height="100%" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path d="M3 12H21M3 6H21M3 18H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>
          <ul class="dropdown-menu">
            <li>
              <input type="checkbox" id="beginner" name="level" value="Beginner">
              <label for="beginner">Başlangıç</label>
            </li>
            <li>
              <input type="checkbox" id="intermediate" name="level" value="Intermediate">
              <label for="intermediate">Orta</label>
            </li>
            <li>
              <input type="checkbox" id="advanced" name="level" value="Advanced">
              <label for="advanced">İleri</label>
            </li>
            <li>
              <input type="checkbox" id="expert" name="level" value="Expert">
              <label for="expert">Uzman</label>
            </li>
            <li>
              <input type="checkbox" id="master" name="level" value="Master">
              <label for="master">Profosyonel</label>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="wrapper">
      <div class="loading-spinner" style="display: none;">
        <div class="spinner"></div>
        <p>Yükleniyor...</p>
      </div>
      <div class="main-text" style="user-select: none; display: none;">
        <h2>Ne öğrenmek istersiniz?</h2>
        <h3>Hadi, birlikte keşfetmeye başlayalım ve yeni şeyler bulalım!</h3>
      </div>
      
      <div class="main-container">
        <div class="content-wrapper">
          <div class="content-section">
            <div class="content-section-title" style="user-select: none;">
              Sonuç</div>
            <div class="apps-card">
              <div class="app-card">
                <span>
                  <svg width="100%" height="100%" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M12 2C14.5013 4.73835 15.9228 8.29203 16 12C15.9228 15.708 14.5013 19.2616 12 22M12 2C9.49872 4.73835 8.07725 8.29203 8 12C8.07725 15.708 9.49872 19.2616 12 22M12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22M12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22M2.50002 9H21.5M2.5 15H21.5" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  ${item.header}
              </span>
              <div class="app-card-buttons">
                  <div class="links">
                  ${(item.sources || []).map((source, index) => `<a href="${source}" target="_blank">Kaynak ${index + 1}</a>`).join(" ")}
                  </div>
                  <button class="content-button status-button">More</button>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
    <div class="overlay-app"></div>
  </div>
  
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src="./js/index.js"></script>

</body>

</html>