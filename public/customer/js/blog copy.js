// دالة عرض البيانات في الجدول
function renderData(response, isAdd = false) {
    let blogs = Array.isArray(response) ? response : [response.blog];
    let tableBody = '';
    let mode = localStorage.getItem('mode');
    let readMore = document.documentElement.lang === 'ar' ? 'إقراء المزيد' : 'Read More';
    if (blogs.length > 0) {
        blogs.forEach(blog => {
            const {
                id,
                title,
                description,
                image,
                slug
            } = blog;
            tableBody += `
                <div class="portfolio-box mix uiux text-right" id="user-${id}">
                    <div class="portfolio-content">
                        <h3 data-en="${title}">${title}</h3>
                        <p data-en="${description}">${description}</p>
                        <a href="http://127.0.0.1:8000/blogs/${slug}" class="readMore">${readMore}</a>
                    </div>
                    <div class="portfolio-img row m-1 justify-content-center" style="position: relative;">
                        <img id="image-blog" src="${image}" title="${title}" alt="${title}" loading="lazy">
                    </div>
                </div>
            `;
        });
    } else {
        tableBody = `<tr id='notfound'><td colspan="7"><h2 class="text-center">لا يوجد مدونات</h2></td></tr>`;
    }

    const $tableBody = $(".boxing .portfolio-gallery");
    !isAdd ? $tableBody.html(tableBody) : $tableBody.prepend(tableBody);
}

function renderLoading() {
    const $tableBody = $(".boxing .portfolio-gallery");
    $tableBody.html("");
    Array(10).fill().forEach(() => {
        $tableBody.append(`
            <div class="portfolio-box">
                <div class="portfolio-content">
                    <h3 class="wrapper-title card__skeleton"></h3>
                    <p class="wrapper-body card__skeleton"></p>
                    <p class="wrapper-body card__skeleton"></p>
                    <p class="wrapper-body card__skeleton"></p>
                    <a href="#" class="readMore wrapper-footer card__skeleton"></a>
                </div>
                <div class="portfolio-img wrapper-img card__skeleton" style="height: 100%;"></div>
            </div>
        `);
    });
}

