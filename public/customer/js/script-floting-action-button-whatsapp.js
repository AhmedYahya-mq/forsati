class WhatsAppChat {
    // إعداد الرسائل حسب اللغة
    static messages = {
        en: {
            help: "I can assist you.",
            helpText: "How can I assist you?",
            greeting: "Hello 👋",
            typeHere: "Type your message here...",
            online: "Online",
            send: "Send",
        },
        ar: {
            help: "يمكنني مساعدتك.",
            helpText: "كيف يمكنني مساعدك؟",
            greeting: "مرحبًا 👋",
            typeHere: "اكتب رسالتك هنا...",
            online: "متصل",
            send: "إرسال",
        }
    };

    // دالة init لإنشاء واجهة الدردشة
    static init(parentElement, phoneNumber, appName, image, lang = 'ar') {
        const container = document.querySelector(parentElement);
        if (!container) return;

        const currentLang = this.messages[lang];
        this.createChatHTML(container, currentLang, appName, image, lang);
        this.setupEventListeners(phoneNumber);
        WhatsAppChat.runAnimationCycle(container.querySelector('.box-whatsapp'), container.querySelector('.box-message'), 2000);
    }

    // دالة لإنشاء HTML واجهة الدردشة
    static createChatHTML(container, messages, appName, image, lang = 'ar') {
        container.innerHTML = `
        <div class="box-whatsapp" dir="${messages === this.messages.ar ? 'rtl' : 'ltr'}">
            <i class="fab fa-whatsapp click"></i>
            <div class="box-message hide">
                <span>${messages.help}</span>
            </div>
            <div class="whatsApp-poems"><span>1</span></div>
            <div class="box-chat">
                <div class="header-chat">
                    <div class="close-box-chat ${lang}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </div>
                    <div class="profile-img">
                        <img loading="lazy" src="${image}" alt="${appName}">
                    </div>
                    <div class="info-chat" style="margin: 0;">
                        <p>${appName}</p>
                        <span>${messages.online}</span>
                    </div>
                </div>
                <div class="main-chat">
                    <div class="box-message-chat">
                        <div class="content-message">
                            <p>${messages.greeting}</p>
                            <div class="footer-message-content">
                                <p>${messages.helpText}</p>
                                <span class="time-message-send">12:00</span>
                            </div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="9" height="17" viewBox="0 0 9 17"
                            fill="currentColor" class="BubbleDetail__StyledSvg-sc-1otb0pb-0 lpbmsP">
                            <path d="M0.772965 3.01404C-0.0113096 1.68077 0.950002 0 2.49683 0H9V17L0.772965 3.01404Z"
                                fill="currentColor"></path>
                        </svg>
                    </div>
                </div>
                <div class="footer-chat">
                    <div class="input-message">
                        <textarea type="text" name="message-text" id="message-text"
                            placeholder="${messages.typeHere}"></textarea>
                        <button type="button" name="button" id="send">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28" class="injected-svg" loading="lazy">
                                <path
                                    d="M9.166 7.5a.714.714 0 0 0-.998.83l1.152 4.304a.571.571 0 0 0 .47.418l5.649.807c.163.023.163.26 0 .283l-5.648.806a.572.572 0 0 0-.47.418l-1.153 4.307a.714.714 0 0 0 .998.83l12.284-5.857a.715.715 0 0 0 0-1.29L9.166 7.5Z">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>`;
    }

    // دالة لتجهيز مستمعي الأحداث
    static setupEventListeners(phoneNumber) {
        const sendButton = document.querySelector('#send');
        sendButton.addEventListener('click', function () {
            const message = document.querySelector('#message-text').value.trim();
            if (message) { // التحقق من وجود رسالة
                WhatsAppChat.sendMessage(phoneNumber, message);
                document.querySelector('#message-text').value = ''; // مسح حقل الإدخال بعد الإرسال
            }
        });

        const clickButton = document.querySelector('.click');
        const closeButton = document.querySelector('.close-box-chat');
        const boxChat = document.querySelector('.box-chat');

        clickButton.addEventListener("click", () => {
            boxChat.classList.toggle('show');
        });

        closeButton.addEventListener("click", () => {
            boxChat.classList.toggle('show');
        });
    }

    // دالة لإرسال الرسالة عبر WhatsApp
    static sendMessage(phoneNumber, message) {
        const whatsappURL = `https://api.whatsapp.com/send?phone=${phoneNumber}&text=${encodeURIComponent(message)}`;
        window.open(whatsappURL, '_blank');
    }

    // دالة لتبديل حالة الرسوم المتحركة
    static toggleAnimation(state, boxWhatsApp, boxMessage) {
        if (state === 'running') {
            boxWhatsApp.classList.remove('paused');
            boxMessage.classList.remove('hide');
        } else if (state === 'paused') {
            boxWhatsApp.classList.add('paused');
            boxMessage.classList.add('hide');
        }
    }

    // دالة لتشغيل دورة الانميش
    static runAnimationCycle(boxWhatsApp, boxMessage, animationDuration) {
        WhatsAppChat.toggleAnimation('paused', boxWhatsApp, boxMessage);
        setTimeout(() => {
            console.log(4 * animationDuration + 150);
            WhatsAppChat.toggleAnimation('running', boxWhatsApp, boxMessage);
            setTimeout(() => WhatsAppChat.runAnimationCycle(boxWhatsApp, boxMessage, animationDuration), 8500);
        }, 4 * animationDuration + 500);
    }
}

// استخدام الكلاس
WhatsAppChat.init('.chat-whatsapp', '+967771508902', document.title, 'http://127.0.0.1:8000/customer/assets/logo.png', document.documentElement.lang);
