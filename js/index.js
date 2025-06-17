$(function () {
  $(".menu-link").click(function () {
    $(".menu-link").removeClass("is-active");
    $(this).addClass("is-active");
  });
});

$(function () {
  $(".main-header-link").click(function () {
    $(".main-header-link").removeClass("is-active");
    $(this).addClass("is-active");
  });
});

const dropdowns = document.querySelectorAll(".dropdown");
dropdowns.forEach((dropdown) => {
  const toggle = dropdown.querySelector(".dropdown-toggle");

  if (toggle) { // toggle'ın null olup olmadığını kontrol et
    toggle.addEventListener("click", (e) => {
      e.stopPropagation();
      dropdowns.forEach((otherDropdown) => {
        if (otherDropdown !== dropdown) {
          otherDropdown.classList.remove("is-active");
        }
      });
      dropdown.classList.toggle("is-active");
    });
  }
});

// Belgeye tıklanınca açık dropdown'ları kapat
document.addEventListener("click", (e) => {
  dropdowns.forEach((dropdown) => {
    if (!dropdown.contains(e.target)) {
      dropdown.classList.remove("is-active");
    }
  });
});


$(document).click(function (e) {
  var container = $(".status-button");
  var dd = $(".dropdown");
  if (!container.is(e.target) && container.has(e.target).length === 0) {
    dd.removeClass("is-active");
  }
});

$(function () {
  $(".dropdown").on("click", function (e) {
    $(".content-wrapper").addClass("overlay");
    e.stopPropagation();
  });
  $(document).on("click", function (e) {
    if ($(e.target).is(".dropdown") === false) {
      $(".content-wrapper").removeClass("overlay");
    }
  });
});

$(function () {
  $(".status-button:not(.open)").on("click", function (e) {
    $(".overlay-app").addClass("is-active");
  });
  $(".pop-up .close").click(function () {
    $(".overlay-app").removeClass("is-active");
  });
});

$(".status-button:not(.open)").click(function () {
  $(".pop-up").addClass("visible");
});

$(".pop-up .close").click(function () {
  $(".pop-up").removeClass("visible");
});

const toggleButton = document.querySelector('.dark-light');

toggleButton.addEventListener('click', () => {
  document.body.classList.toggle('light-mode');
});



document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.querySelector(".search-bar input");

  searchInput.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
      const query = searchInput.value.trim();
      if (query !== "") {
        fetchResults(query);
      }
    }
  });
});

// Seçilen seviyeyi bir çereze kaydet
function saveLevelToCookie(level) {
  document.cookie = `selectedLevel=${level}; path=/; max-age=31536000`; // 1 yıl geçerli
}

// Çerezi oku ve uygun checkbox'ı seçili yap
function loadLevelFromCookie() {
  const cookies = document.cookie.split("; ");
  const levelCookie = cookies.find(cookie => cookie.startsWith("selectedLevel="));

  if (levelCookie) {
    const level = levelCookie.split("=")[1];
    const checkbox = document.querySelector(`input[value="${level}"]`);
    if (checkbox) {
      checkbox.checked = true;
    }
  }
}

// Sadece bir checkbox'ın seçilmesini sağlamak
function handleCheckboxChange(event) {
  const checkboxes = document.querySelectorAll('input[name="level"]');
  checkboxes.forEach(checkbox => {
    if (checkbox !== event.target) {
      checkbox.checked = false;
    }
  });

  // Seçilen seviyeyi çereze kaydet
  saveLevelToCookie(event.target.value);
}

// Sayfa yüklendiğinde çerezi oku ve seçimi uygula
document.addEventListener("DOMContentLoaded", () => {
  loadLevelFromCookie();

  const checkboxes = document.querySelectorAll('input[name="level"]');
  checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', handleCheckboxChange);
  });
  const mainText = document.querySelector(".main-text");
  const mainContainer = document.querySelector(".main-container");
  mainContainer.style.display = "none";
  mainText.style.display = "flex";
});

const apiKey = 'AIzaSyDBocMFBh3FSddn5dcYPfxu24Pr2HpUo-A';

function staticPrompt(search, language, level) {
  let prompt = `
      Lütfen aşağıdaki JSON formatına uyan bir çıktı üretiniz. Yanıtınızda ekstra açıklama, yorum veya metin bulunmasın; sadece belirtilen JSON yapısını kullanınız. Kullanıcının 'search' ve 'level' verilerini giriş olarak alınız ve bu verilere göre ${language} dilinde **tek bir içerik** oluşturunuz.
      
      **JSON formatında dikkat edilmesi gerekenler:**  
      - **"detail" alanı:**  
        - Konuyla ilgili **kapsamlı, öğretici ve derinlemesine bir açıklama** içermelidir.  
        - Açıklamada **tarihçe, kullanım alanları, örnekler ve önemli noktalar** yer almalıdır.  
        - Metin **en az 300 kelime uzunluğunda** olmalıdır.  
        - JSON formatını korumak için çift tırnak (\`"\`) yerine tek tırnak (\`'\`) kullanılmalı veya kaçış karakteri (\`\\\"\`) ile belirtilmelidir.  
      
      - **"questions" alanı:**  
        - **İlk soru**  tek kelimelik ve kısa cevap gerektiren boşluk doldurma formatında oluşturun. Yazımı kolay, anlaşılır ve net bir şekilde hazırlanmalıdır.
        - **İkinci soru** test formatında olmalı, **birden fazla seçenek içermeli** ve doğru cevabın indeks numarası belirtilmelidir.  
      
      ---
      
      **JSON Formatı:**  
      
      \`\`\`json  
      {
          "search": "${search}",
          "level": "${level}",
          "results": {
              "content": {
                  "header": "<Özet veya Başlık bilgisi>",
                  "detail": "<Kapsamlı ve öğretici açıklama>",
                  "sources": ["<Kaynak URL 1>", "<Kaynak URL 2>"],
                  "questions": {
                  "0": {
                      "question": "<Klasik soru>",
                      "answer": "<Doğru cevap>"
                  },
                  "1": {
                      "question": "<Test sorusu>",
                      "answers": {
                          "0": "<Şık 1>",
                          "1": "<Şık 2>",
                          "2": "<Şık 3>",
                          "3": "<Şık 4>",
                          "4": "<Şık 5>"
                      },
                      "correctAnswer": 0
                  }
              },
            }
          }
      }
      \`\`\`
      `;

  return prompt
}

function getLevelFromCookie() {
  const cookies = document.cookie.split('; ');
  for (let cookie of cookies) {
      const [name, value] = cookie.split('=');
      if (name === 'selectedLevel') {
          return value;
      }
  }
  return null; // Cookie bulunamazsa null döner
}

function fetchResults(query) {
  const mainText = document.querySelector(".main-text");
  const mainContainer = document.querySelector(".main-container");
  const loadingSpinner = document.querySelector('.loading-spinner');
  mainText.style.display = "none";
  mainContainer.style.display = "none";
  loadingSpinner.style.display = 'flex';
  const level = getLevelFromCookie();
  console.log(level);
  const requestData = {
    "contents": [{
      "parts": [{ "text": staticPrompt(query, 'tr', level) }]
    }]
  };

  // Remove the undefined console.log(data) - it should be requestData
  console.log("AAA", requestData); // Corrected variable name

  fetch(`https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=${apiKey}`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(requestData)
  })
    .then(response => response.json())
    .then(data => {
      const container = document.querySelector(".apps-card");
      container.innerHTML = "";
      console.log(data.candidates[0].content.parts[0].text);
      loadingSpinner.style.display = 'none';
      mainContainer.style.display = "flex";
      let test = data.candidates[0].content.parts[0].text;
      response = test.replace(/^```json\s*/, '').replace(/\s*```$/, '');
      response = response.slice(0, -4);
      response = response.trim();
      try {
        response = JSON.parse(response); // Convert to JSON object
      } catch (error) {
        console.error("JSON parse hatası:", error);
        return;
      }

      console.log(response)
      Object.values(response.results).forEach(item => {
        const card = document.createElement("div");
        card.classList.add("app-card");

        card.innerHTML = `
        <span>
            <svg width="100%" height="100%" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2C14.5013 4.73835 15.9228 8.29203 16 12C15.9228 15.708 14.5013 19.2616 12 22M12 2C9.49872 4.73835 8.07725 8.29203 8 12C8.07725 15.708 9.49872 19.2616 12 22M12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22M12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22M2.50002 9H21.5M2.5 15H21.5" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            ${item.header}
        </span>
        <div class="app-card-buttonstest"></div>
        <div class="app-card-buttons">
            <div class="soruheader">
                <span class="soruisaret">
                    <svg width="100%" height="100%" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.09 9C9.3251 8.33167 9.78915 7.76811 10.4 7.40913C11.0108 7.05016 11.7289 6.91894 12.4272 7.03871C13.1255 7.15849 13.7588 7.52152 14.2151 8.06353C14.6713 8.60553 14.9211 9.29152 14.92 10C14.92 12 11.92 13 11.92 13M12 17H12.01M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Sorular
                </span>
            </div>
            
            <div class="questions">
                <!-- Radio sorusu: -->
                <div class="question" data-correct-index="${item.questions[1].correctAnswer}">
                    <span class="question-text">${item.questions[1].question}</span>
                    <div class="answers">
                        ${(Object.entries(item.questions[1].answers || {})).map(([index, answer]) => `
                            <span class="answer">
                                <input type="radio" name="answerTest-${item.id}" value="${index}" /> &nbsp; ${answer}
                            </span>
                        `).join(" ")}
                    </div>
                    <!-- Buton ekleniyor: -->
                    <div class="btn"><button class="submit-answer">Cevabı Gönder</button></div>
                    
                    <!-- Geri bildirim mesajı için boş div: -->
                    <div class="answer-feedback"></div>
                </div>
                
                <!-- Diğer soru tipi (örneğin text input): -->
                <div class="question" data-correct-answer="${item.questions[0].answer}">
                  <span class="question-text">${item.questions[0].question}</span>
                  <div class="answers">
                    <input  class="text-answer" type="text">
                  </div>
                  <div class="btn">
                    <button class="submit-answer9">Cevabı Gönder</button>
                  </div>
                  <!-- Geri bildirim için boş div -->
                <div class="answer-feedback"></div>
              </div>
            </div>
            
            <div class="app-card-buttons">
                <div class="links">
                    ${(item.sources || []).map((source, index) => `<a href="${source}" target="_blank">Kaynak ${index + 1}</a>`).join(" ")}
                </div>
            </div>
      `;
      
      // Alt detay metnini ekleme
      const subtextDiv = document.createElement("div");
      subtextDiv.classList.add("app-card__subtext");
      subtextDiv.textContent = item.detail || "No details available";
      card.setAttribute('data-original-detail', item.detail || "");
      card.insertBefore(subtextDiv, card.querySelector(".app-card-buttons"));
      container.appendChild(card);
      });
    })
    .catch(error => {
      loadingSpinner.style.display = 'none';
      console.error("Veri çekme hatası:", error);
    });
}

document.querySelector('.apps-card').addEventListener('click', function(e) {
  if(e.target.matches('.submit-answer')){
    const questionDiv = e.target.closest('.question');
    const selectedRadio = questionDiv.querySelector('input[type="radio"]:checked');
    const correctIndex = questionDiv.getAttribute('data-correct-index');
    const feedbackDiv = questionDiv.querySelector('.answer-feedback');
    
    if(!selectedRadio) {
      // Hiçbir cevap seçilmediyse
      feedbackDiv.textContent = 'Lütfen bir cevap seçin.';
      feedbackDiv.classList.remove('correct');
      feedbackDiv.classList.add('incorrect');
    } else if(selectedRadio.value === correctIndex) {
      // Doğru cevap
      feedbackDiv.textContent = 'Doğru cevap!';
      feedbackDiv.classList.remove('incorrect');
      feedbackDiv.classList.add('correct');
    } else {
      feedbackDiv.textContent = 'Yanlış cevap. 😢 Lütfen tekrar deneyin.';
      feedbackDiv.classList.remove('correct');
      feedbackDiv.classList.add('incorrect');
    }
  }
  if(e.target.matches('.submit-answer9')){
    const questionDiv = e.target.closest('.question');
    const userAnswer = questionDiv.querySelector('input[type="text"]').value.trim();
    const correctAnswer = questionDiv.getAttribute('data-correct-answer');
    const feedback = questionDiv.querySelector('.answer-feedback');

    if(!userAnswer) {
      feedback.textContent = 'Lütfen bir cevap girin.';
      feedback.classList.add('incorrect');
      return;
    }

    if(userAnswer.toLowerCase() === correctAnswer.toLowerCase()) {
      feedback.textContent = 'Doğru cevap! 🎉';
      feedback.classList.remove('incorrect');
      feedback.classList.add('correct');
    } else {
      feedback.textContent = `Yanlış cevap. Doğru cevap: ${correctAnswer}`;
      feedback.classList.remove('correct');
      feedback.classList.add('incorrect');
    }
  }
});


// Tüm text input içeren soruları seçiyoruz.
document.querySelectorAll(".question").forEach(question => {
  // Sadece text input varsa bu soruya event listener ekleyelim.
  console.log('diuwqnmdo,qwmdioqkioqw,doqwmdoq,doqmq')
  if (question.querySelector("input[type='text']")) {
    const submitBtn = question.querySelector(".submit-answer9");
    submitBtn.addEventListener("click", function() {
      // Kullanıcının girdiği cevabı al
      const userAnswer = question.querySelector("input[type='text']").value.trim();
      // Doğru cevabı data attribute'dan oku
      const correctAnswer = question.getAttribute("data-correct-answer");
      // Geri bildirim için boş div
      const feedback = question.querySelector(".answer-feedback");
      
      // Karşılaştırma (küçük büyük harf duyarsız)
      if (userAnswer.toLowerCase() === correctAnswer.toLowerCase()) {
        feedback.textContent = "Doğru cevap!";
      } else {
        feedback.textContent = `Yanlış cevap. Doğru cevap: ${correctAnswer}`;
      }
    });
  }
});
