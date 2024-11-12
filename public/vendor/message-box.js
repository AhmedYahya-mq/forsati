class Popup {
    static MessageType = Object.freeze({
        SUCCESS: 'success',
        ALERT: 'alert',
        ERROR: 'error'
    });

    // دالة لبناء HTML للرسالة بناءً على النوع
    static buildPopupHTML(type, message) {
        let iconClass, messageClass;

        switch (type) {
            case Popup.MessageType.SUCCESS:
                iconClass = 'fa-circle-check';
                messageClass = 'success-popup';
                break;
            case Popup.MessageType.ALERT:
                iconClass = 'fa-triangle-exclamation';
                messageClass = 'alert-popup';
                break;
            case Popup.MessageType.ERROR:
                iconClass = 'fa-circle-xmark';
                messageClass = 'error-popup';
                break;
            default:
                console.error('Invalid message type');
                return null; // نوع الرسالة غير صالح
        }

        return `
        <div class="popup ${messageClass}">
            <div class="popup-icon ${type}-icon">
                <i class="fa-solid ${iconClass}"></i>
            </div>
            <div class="${type}-message">${message}</div>
            <div class="popup-icon close-icon">
                <i class="fa-solid fa-xmark close-svg close-path"></i>
            </div>
        </div>`;
    }

    // دالة لإضافة الرسالة إلى DOM
    static appendPopupToDOM(containerSelector, popupHTML) {
        $(containerSelector).append(popupHTML);
    }

    // دالة لتمكين إغلاق الرسالة عند الضغط على زر الإغلاق
    static enableCloseOnClick() {
        $(document).on('click', '.close-icon', function () {
            $(this).closest('.popup').animate({
                top: "0px",
                opacity: 0
            }, 1000, function () {
                $(this).remove();
            });
        });
    }

    // دالة لحذف الرسالة بعد 3 ثوانٍ مع حركة الاختفاء
    static removePopupAfterDelay($popup,style={top: "0px"}) {
        setTimeout(() => {
            $popup.animate({
                ...style,
                opacity: 0 // تخفيف الرسالة تدريجياً
            }, 1000, function () {
                $popup.remove();
            });
        }, 3000);
    }

    // دالة عامة لعرض الرسالة
    static showPopup(type, message, containerSelector = '.popup-container') {
        const popupHTML = Popup.buildPopupHTML(type, message);
        if (!popupHTML) return; // إذا كان النوع غير صالح، لا تفعل شيء

        Popup.appendPopupToDOM(containerSelector, popupHTML);

        const $popup = $(containerSelector + ' .popup').last(); // الحصول على العنصر الأخير (الذي تم إضافته الآن)

        // عند الإظهار، تحريك الرسالة من top 0 إلى top 100
        $popup.css({
            position: "fixed",
            top: "0px",
            left: "50%",
            transform: "translateX(-50%)",
            opacity: 0,
            'z-index':'99999999999999999'
        }).animate({
            top: "50px", // التحرك إلى الأسفل بمقدار 100px
            opacity: 1 // إظهار الرسالة تدريجياً
        }, 1000); // مدة الحركة 1000ms

        Popup.removePopupAfterDelay($popup); // تمرير العنصر نفسه إلى دالة الإخفاء
        Popup.enableCloseOnClick(); // تمكين الإغلاق عند الضغط
    }
}

class ConfirmBox {
    static result = null;

    static show({ message = 'هل أنت متأكد؟', confirmText = 'تأكيد', cancelText = 'إلغاء', defaultAction = 'cancel' } = {}) {
        return new Promise((resolve) => {
            // إنشاء صندوق التأكيد
            this.createConfirmBox({ message, confirmText, cancelText, defaultAction });
            // مستمع لوحة المفاتيح
            this.keydownListener = (event) => {
                const focusedButton = document.activeElement;
                if (event.key === 'Enter') {
                    focusedButton.click(); // تنفيذ الزر المحدد عند الضغط على Enter
                } else if (event.key === 'Tab' || event.key === 'ArrowRight') {
                    this.switchFocus(); // التبديل بين الأزرار باستخدام Tab أو سهم اليمين
                } else if (event.key === 'ArrowLeft') {
                    this.switchFocus(true); // التبديل باستخدام سهم اليسار
                }
            };
            document.addEventListener('keydown', this.keydownListener);

            // إضافة مستمعات للأزرار
            this.cancelButton.addEventListener('click', () => {
                this.handleResult(false);
                resolve(false);
            });

            this.confirmButton.addEventListener('click', () => {
                this.handleResult(true);
                resolve(true);
            });

            // معالجة التركيز على الزر الافتراضي
            this.removeAllFocus(); // إزالة التركيز عن أي عنصر آخر
            this.setInitialFocus(defaultAction);
        });
    }

    static createConfirmBox({ message, confirmText, cancelText, defaultAction }) {
        // إنشاء العناصر
        this.confirmBox = document.createElement('div');
        this.confirmBox.className = 'box-confirm';

        this.confirmInner = document.createElement('div');
        this.confirmInner.className = 'confirm';

        const title = document.createElement('h1');
        title.textContent = 'تأكيد العملية';

        const messageElement = document.createElement('p');
        messageElement.innerHTML = message;

        this.cancelButton = document.createElement('button');
        this.cancelButton.textContent = cancelText;

        this.confirmButton = document.createElement('button');
        this.confirmButton.textContent = confirmText;

        // إضافة العناصر للصندوق
        this.confirmInner.appendChild(title);
        this.confirmInner.appendChild(messageElement);
        this.confirmInner.appendChild(this.cancelButton);
        this.confirmInner.appendChild(this.confirmButton);
        this.confirmBox.appendChild(this.confirmInner);

        // إضافة الصندوق للـ DOM
        document.body.prepend(this.confirmBox);
        console.log( document.body.querySelector('.box-confirm'))

    }

    static removeAllFocus() {
        // إزالة التركيز عن أي عنصر آخر
        document.activeElement.blur();
    }

    static setInitialFocus(defaultAction) {
        // ضبط التركيز الافتراضي على الزر المناسب
        if (defaultAction === 'cancel') {
            this.cancelButton.focus();
        } else {
            this.confirmButton.focus();
        }
    }

    static switchFocus(reverse = false) {
        // التبديل بين الأزرار
        if (reverse) {
            if (document.activeElement === this.confirmButton) {
                this.cancelButton.focus();
            } else {
                this.confirmButton.focus();
            }
        } else {
            if (document.activeElement === this.cancelButton) {
                this.confirmButton.focus();
            } else {
                this.cancelButton.focus();
            }
        }
    }

    static handleResult(result) {
        // تعيين النتيجة وإزالة الصندوق
        this.result = result;
        this.removeConfirmBox();
    }

    static removeConfirmBox() {
        // إزالة صندوق التأكيد
        this.confirmBox.remove();
        document.removeEventListener('keydown', this.keydownListener); // إزالة مستمع لوحة المفاتيح
    }
}
