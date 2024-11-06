class CommentManager {
    constructor(apiUrl,apiAdd) {
        this.apiUrl = apiUrl;
        this.apiAdd= apiAdd;
        this.currentUser = {
            id: 999, // ID مؤقت للمستخدم الحالي
            name: "juliusomo",
            image: "default.png" // رابط صورة المستخدم
        };
        this.currentlyOpenedReplyForm = null;
        this.commentsPage = 1; // الصفحة الحالية
        this.commentsPerPage = 10; // عدد التعليقات لكل صفحة
        this.fetchComments(); // تحميل التعليقات عند إنشاء الكائن
        this.initLoadMoreButton();
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
            const newCommentData = this.buildCommentData(content, parentId);
            const savedComment = await this.saveCommentToDatabase(newCommentData);

            this.appendCommentToUI(savedComment, parentId, replyWrapper, replyNode);
        } catch (error) {
            console.error("Error adding comment:", error);
        }
    }

    // إنشاء بيانات التعليق
    buildCommentData(content, parentId) {
        return {
            content: content,
            parent_id: parentId,
            user_id: this.currentUser.id // ID المستخدم الحالي
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
    appendCommentToUI(comment, parentId, replyWrapper, replyNode) {
        const commentParent = parentId === null ? this.data : this.findCommentById(parentId).replies;
        commentParent.push(comment);

        const commentNode = this.createCommentNode(comment);

        if (replyWrapper) {
            replyWrapper.prepend(commentNode);
        } else if (replyNode) {
            $(replyNode).after(commentNode);
        } else {
            document.querySelector(".comments-wrp .comments-wrp").appendChild(commentNode);
        }
    }

    // دالة لإنشاء عنصر HTML للتعليق
    createCommentNode(comment) {
        const commentNode = document.createElement("div");
        commentNode.className = "comment-wrp";
        commentNode.innerHTML = this.getCommentTemplate(comment);

        commentNode.querySelector(".reply-btn").addEventListener("click", () =>
            this.handleReplyButtonClick(commentNode, comment)
        );

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
                    <p class="cmnt-at">${comment.created_at}</p>
                </div>
                <p class="c-text">
                    <span class="reply-to">${comment.parent_id ? '@' + comment.user.name : ''}</span>
                    ${comment.content}
                </p>
                <button class="reply-btn">${document.lang === "en" ? "Reply" : "رد"}</button>
            </div>
            <div class="replies comments-wrp"></div>
        `;
    }

    // معالجة الضغط على زر الرد
    handleReplyButtonClick(commentNode, comment) {

        if (this.currentlyOpenedReplyForm && this.currentlyOpenedReplyForm !== commentNode) {
            $(this.currentlyOpenedReplyForm).next(".reply-input.container-comment").remove();
            this.currentlyOpenedReplyForm = null;
        }

        const existingReplyInput = $(commentNode).next(".reply-input.container-comment");
        console.log(existingReplyInput);

        if (existingReplyInput.length !== 0) {
            existingReplyInput.remove();
            this.currentlyOpenedReplyForm = null;
        } else {
            const replyInputNode = this.createReplyInputNode(commentNode, comment);
            console.log(commentNode);

            commentNode.after(replyInputNode);
            this.currentlyOpenedReplyForm = commentNode;
        }
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
            this.addComment(replyInput.value, comment.id, replyWrapper, replyInputNode);
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
}

// Example usage
const blogId = document.querySelector("meta[name='blog']").getAttribute("content");
const token = document.querySelector("meta[name='token']").getAttribute("content");
const apiUrl = `http://127.0.0.1:8000/api/blogs/comments/blog/${blogId}`;
const apiAdd = `api/blogs/comment/`;
const commentManager = new CommentManager(apiUrl,apiAdd);
