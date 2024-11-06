class CommentManager {
    constructor(type, apiUrl, apiAdd, currentUser) {
        this.type = type;
        this.apiUrl = apiUrl;
        this.apiAdd = apiAdd;
        this.currentUser = currentUser;
        this.currentlyOpenedReplyForm = null;
        this.currentCommentNode = null;
        this.commentsPage = 1; // الصفحة الحالية
        this.commentsPerPage = 10; // عدد التعليقات لكل صفحة
        this.fetchComments(); // تحميل التعليقات عند إنشاء الكائن
        this.initLoadMoreButton();
        this.initReplayBaseForm();
    }

    // الدالة المسؤولة عن تحميل التعليقات من الـ API
    async fetchComments() {
        try {
            const response = await fetch(`${this.apiUrl}`);
            const data = await response.json();
            this.data = data.data;
            this.renderComments();
            this.apiUrl = data.next_page;
            if (!this.apiUrl)
                document.querySelector("#view-comment").remove();
        } catch (error) {
            console.error("Error fetching comments:", error);
        }
    }

    // دالة لتحميل المزيد من التعليقات
    async loadMoreComments() {
        await this.fetchComments();
    }

    // دالة لإضافة تعليق جديد وحفظه في قاعدة البيانات
    async addComment(content, parentId = null, replyWrapper = null, replyNode = null) {
        try {
            const ref_id = $(`meta[name="${this.type}"]`).attr('content');
            const newCommentData = this.buildCommentData(content, parentId, ref_id);
            const savedComment = await this.saveCommentToDatabase(newCommentData);

            this.appendCommentToUI(savedComment, parentId);
        } catch (error) {
            console.error("Error adding comment:", error);
        }
    }

    // إنشاء بيانات التعليق
    buildCommentData(content, parentId, ref_id) {
        return {
            content: content,
            parent_id: parentId,
            user_id: this.currentUser.id, // ID المستخدم الحالي
            [this.type + "_id"]: ref_id || null // تعيين الرقم التسلسلي للتعليق عند نوع معين
        };
    }

    // دالة لحفظ التعليق الجديد في قاعدة البيانات عبر طلب POST
    async saveCommentToDatabase(commentData) {
        const response = await fetch(this.apiAdd, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            body: JSON.stringify(commentData)
        });

        if (!response.ok) throw new Error("Failed to save comment");
        return await response.json();
    }

    // إضافة التعليق إلى الواجهة بعد حفظه بنجاح
    appendCommentToUI(comment, parentId = null) {
        $(".no-comments").remove();
        const commentNode = this.createCommentNode(comment);

        if (this.currentlyOpenedReplyForm) {
            $(this.currentlyOpenedReplyForm).after(commentNode);
            this.currentlyOpenedReplyForm.remove();
            this.currentlyOpenedReplyForm = null;
        } else {
            document.querySelector(".comments-wrp .comments-wrp").appendChild(commentNode);
        }
    }

    // دالة لإنشاء عنصر HTML للتعليق
    createCommentNode(comment) {
        const commentNode = document.createElement("div");
        commentNode.className = "comment-wrp";
        commentNode.innerHTML = this.getCommentTemplate(comment);
        if (this.currentUser.id) {
            commentNode.querySelector(".reply-btn").addEventListener("click", () =>
                this.handleReplyButtonClick(commentNode, comment)
            );
        }

        return commentNode;
    }

    // قالب HTML للتعليق
    getCommentTemplate(comment) {
        return `
            <div class="comment container-comment">
                <div class="">
                </div>
                <div class="c-user">
                    <img src="${comment.user.image}" alt="" class="usr-img">
                    <p class="usr-name">${comment.user.name}</p>
                    <p class="cmnt-at">${comment.date}</p>
                </div>
                <p class="c-text">
                    <span class="reply-to">${comment.parent_id ? '@' + comment.user.name : ''}</span>
                    ${comment.content}
                </p>
                ${this.currentUser.id?`<button class="reply-btn">${document.lang === "en" ? "Reply" : "رد"}</button>`:""}
            </div>
            <div class="replies comments-wrp"></div>
        `;
    }

    // معالجة الضغط على زر الرد
    handleReplyButtonClick(commentNode, comment) {
        console.log(commentNode.contains(this.currentlyOpenedReplyForm));

        // إذا كان هناك نموذج مفتوح بالفعل وكان للـ commentNode نفسه، فقم بإزالته وأعد التهيئة
        if (this.currentlyOpenedReplyForm) {
            if (this.currentCommentNode === commentNode) {
                this.currentlyOpenedReplyForm.remove();
                this.currentlyOpenedReplyForm = null;
                this.currentCommentNode = null;
                return;
            } else {
                // إزالة النموذج السابق إذا كان يخص `commentNode` مختلف
                this.currentlyOpenedReplyForm.remove();
            }
        }

        // إنشاء نموذج الرد الجديد
        const replyInputNode = this.createReplyInputNode(commentNode, comment);

        // تحديد موقع الإدراج: كابن ثانٍ أو كآخر عنصر
        const insertPosition = commentNode.children.length > 1 ? commentNode.children[1] : null;

        // إدراج نموذج الرد الجديد في الموضع المحدد
        commentNode.insertBefore(replyInputNode, insertPosition);

        // تحديث المتغيرات لتتبع النموذج الحالي
        this.currentlyOpenedReplyForm = replyInputNode;
        this.currentCommentNode = commentNode;
    }

    // إنشاء نموذج إدخال للرد
    createReplyInputNode(commentNode, comment) {
        const replyInputNode = document.createElement("div");
        replyInputNode.className = "reply-input container-comment";
        replyInputNode.innerHTML = `
            <img src="${this.currentUser.image}" alt="" class="usr-img">
            <textarea class="cmnt-input" placeholder="${document.lang === "en" ? "Add a reply" : "أكتب ردك"}..."></textarea>
            <button class="bu-primary btn-reply">${document.lang === "en" ? "Reply" : "رد"}</button>
            <button class="bu-primary cancel-btn"
                    style="
                        align-self: end;
                        background: red;"
            >${document.lang === "en" ? "Cancel" : "الغاء"}</button>
        `;

        replyInputNode.querySelector(".btn-reply").addEventListener("click", () => {
            const replyInput = replyInputNode.querySelector(".cmnt-input");
            if (replyInput.value.trim() === "") return;

            const replyWrapper = $(commentNode).nextAll('.replies.comments-wrp').first();
            this.addComment(replyInput.value, comment.id);
        });
        replyInputNode.querySelector(".cancel-btn").addEventListener("click", () => {
            replyInputNode.remove();
        });

        return replyInputNode;
    }

    // البحث عن تعليق حسب ID
    findCommentById(id, comments = this.data) {
        for (const comment of comments) {
            if (comment.id === id) return comment;
            const found = this.findCommentById(id, comment.replies);
            if (found) return found;
        }
        return null;
    }

    // عرض التعليقات من البيانات المحملة
    renderComments() {
        const commentsWrapper = document.querySelector(".comments-wrp .comments-wrp");

        this.data.forEach(comment => {
            const commentNode = this.createCommentNode(comment);
            this.renderReplies(comment.replies, $(commentNode).find(".replies.comments-wrp"));
            commentsWrapper.appendChild(commentNode);
        });
        // Check if there are no comments data
        if (this.data.length === 0) {
            $(commentsWrapper).append(`
                <div class="no-comments">
                    ${document.lang === "en" ? "No comments found." : "لا يوجد تعليقات"}
                </div>
            `);
            document.querySelector("#view-comment")?.remove(); // Optional Chaining للتأكد من وجود العنصر قبل إزالته
        }


    }

    // عرض الردود المرتبطة بالتعليق
    renderReplies(replies, replyWrapper) {
        replies.forEach(reply => {
            const replyNode = this.createCommentNode(reply);
            // this.renderReplies(reply.replies, $(replyNode).find(".replies.comments-wrp"));
            this.renderReplies(reply.replies, replyWrapper);
            replyWrapper.prepend(replyNode);
        });
    }

    initLoadMoreButton() {
        if (!apiUrl) {
            document.querySelector("#view-comment").remove();
            return;
        }
        document.querySelector(".load-more").addEventListener("click", async () => {
            $("#view-comment").toggleClass("loading");
            await this.loadMoreComments();
            $("#view-comment")?.toggleClass("loading");
        });
    }

    initReplayBaseForm() {
        $(".reply-input.base-input-reply.container-comment .bu-primary").on("click", async (event) => {
            try {
                console.log($(".reply-input.base-input-reply.container-comment .cmnt-input").val());

                // استخدام this داخل دالة السهم لضمان أنه يشير إلى الكائن الصحيح
                const ref_id = $(`meta[name="${this.type}"]`).attr('content');
                const newCommentData = this.buildCommentData($(".reply-input.base-input-reply.container-comment .cmnt-input").val(), null, ref_id);
                const savedComment = await this.saveCommentToDatabase(newCommentData);

                this.appendCommentToUI(savedComment);
            } catch (error) {
                console.error("Error adding comment:", error);
            }
        });
    }

}

// Example usage
const blogId = document.querySelector("meta[name='blog']").getAttribute("content");
const token = document.querySelector("meta[name='csrf-token']").getAttribute("content");
const currentUser = {
    id: $("header .user-info").data("id") || null,
    name: $("header .user-info img").attr("alt") || null,
    image: $("header .user-info img").attr("src") || null,
}
const apiUrl = `http://127.0.0.1:8000/api/blogs/comments/blog/${blogId}`;
const apiAdd = `http://127.0.0.1:8000/api/blogs/comment/`;
const commentManager = new CommentManager("blog", apiUrl, apiAdd, currentUser);
