class WPFlatsomeHelperStudio {
    #remoteData;
    #postData = {use_in_id: '', title: '', content: ''};

    constructor() {
        this.init();
    }

    init() {
        setInterval(() => this.checkAddButtonIframe(), 100);
        window.addEventListener('message', (event) => this.buttonImportClick(event));
        document.addEventListener('click', (event) => {
            if (event.target.id === 'wpfh-studio-button') { // show iframe
                this.buttonIframeClick();
            } else if (event.target.id === 'wpfh-close-overlay') { // close overlay
                document.querySelector('.flatsome-studio__overlay').remove();
            } else if (event.target.id === 'wpfh-close-iframe') { // close iframe
                document.querySelector('#wpfh-iframe').remove();
            } else if (event.target.id === 'wpfh-start-import') { // start import
                this.buttonStartImportClick();
            }
        });
    }

    getIdFromCurrentUrl() {
        const params = new URLSearchParams(window.location.search);
        if (params.has('edit_post_id')) {
            return params.get('edit_post_id');
        } else if (params.has('post')) {
            return params.get('post');
        } else {
            return null; // or some default value if no ID is found
        }
    }

    async savePostData() {
        // console.log('this.#postData', this.#postData);
        // return;
        const res = await WpFlatsomeHelperAjax.fetchWpfhInsertBlock(this.#postData);
        document.querySelector('#wpfh-iframe .flatsome-studio__box').classList.remove('wpfh-loading');
        var wpfhBox = document.querySelector('#wpfh-iframe .flatsome-studio__box');
        wpfhBox.innerHTML = `
            <h5 class="flatsome-studio__box-title">Done</h5>
            <h2 class="flatsome-studio__box-title">${this.#postData.title}</h2>
            <div class="flatsome-studio__actions">
                <button id="wpfh-close-overlay" class="wp-style">Close</button>
                <a href="${res.url}">
                    <button style="width: 100%" class="wp-style alt">View list</button>
                </a>
            </div>
    `;
    }

    async buttonStartImportClick() {
        // box loading
        document.querySelector('#wpfh-iframe .flatsome-studio__box').classList.add('wpfh-loading');
        const {block, images, content, posts} = this.#remoteData.data.blockExport;
        this.#postData.use_in_id = this.getIdFromCurrentUrl();
        this.#postData.content = content;
        this.#postData.title = block.title;
        let isDownloadImgChecked = document.getElementById('wpfh-import-image').checked;
        let isCreatePostChecked = document.getElementById('wpfh-import-post').checked;
        if (!isCreatePostChecked && !isDownloadImgChecked) {
            this.savePostData();
            return;
        }

        let downloadImgPromise = null;
        let createPostPromise = null;

        if (isDownloadImgChecked && !jQuery.isEmptyObject(images)) {
            let downloadImgPromises = Object.keys(images).reduce((acc, id) => {
                if (images[id]) {
                    acc.push(WpFlatsomeHelperAjax.fetchDownloadImg({ url: images[id], id }).then(res => {
                        return { id, url: images[id], res };
                    }));
                }
                return acc;
            }, []);
            downloadImgPromise = Promise.all(downloadImgPromises).then(results => {
                results.forEach((res) => {
                    this.#postData.content = this.#postData.content.replace(new RegExp(`\\{\\{\\{${res.id}\\}\\}\\}`, 'g'), res.res.data.id);
                    this.#postData.content = this.#postData.content.replace(new RegExp(`\\{\\{<${res.id}>\\}\\}`, 'g'), res.res.data.url);
                });
            }).catch(error => {
                console.error("An error occurred in downloadImgPromise:", error);
            });
        }

        if (isCreatePostChecked && Array.isArray(posts)) {
            let createPostPromises = posts.reduce((acc, post) => {
                acc.push(WpFlatsomeHelperAjax.fetchWpfhPostsCategory(post).then(res => {
                    return { id_cat_2: post.id_cat_2, res };
                }));
                return acc;
            }, []);
            createPostPromise = Promise.all(createPostPromises).then(results => {
                results.forEach((res) => {
                    this.#postData.content = this.#postData.content.replace(new RegExp(`\\[\\[\\[${res.id_cat_2}\\]\\]\\]`, 'g'), res.res.data.category_id);
                });
            }).catch(error => {
                console.error("An error occurred in createPostPromise:", error);
            });
        }

        Promise.all([createPostPromise, downloadImgPromise])
            .then(() => {
                this.#postData.content = this.#postData.content.replace(/(\{\{\{|\{\{<|\}\}\}|\>\}\}|\[\[\[|\]\]\])/g, '');
                this.savePostData();
            })
            .catch(error => {
                console.error("An error occurred in Promise.all:", error);
            });

    }

    async buttonImportClick(event) {
        const wpfh_product_id = event.data?.wpfh_product_id;
        if (!wpfh_product_id) return;
        const res = await WpFlatsomeHelperAjax.fetchProductWithAcf(wpfh_product_id);
        this.#remoteData = res;
        const {block, images, posts} = this.#remoteData.data.blockExport;
        const imageCount = images ? Object.values(images).filter((value) => Boolean(value)).length : 0;
        const postCount = posts ? Object.values(posts).filter((value) => Boolean(value)).length : 0;
        var wpfhOverlay = `<div class="flatsome-studio__overlay" style="background-color: rgba(0,0,0,0.55)"><div class="flatsome-studio__box"><h5 class="flatsome-studio__box-title">Import</h5><h2 class="flatsome-studio__box-title">${block.title}</h2><label class="flatsome-studio__setting"><input id="wpfh-import-image" type="checkbox" checked>Import images (${imageCount})</label><label class="flatsome-studio__setting"><input id="wpfh-import-post" type="checkbox" checked>Import category & post (${postCount})</label><div class="flatsome-studio__actions"><button id="wpfh-close-overlay" class="wp-style">Cancel</button><button id="wpfh-start-import" class="wp-style alt">Start</button></div></div></div>`;
        const iframeElement = document.getElementById('wpfh-iframe');
        iframeElement.insertAdjacentHTML('beforeend', wpfhOverlay);
    }

    checkAddButtonIframe() {
        let flatsomeButton = document.querySelector('.flatsome-studio-button');
        let wpfhButton = document.querySelector('#wpfh-studio-button');
        if (flatsomeButton && !wpfhButton) {
            let newButtonHTML = `<button id="wpfh-studio-button" 
class="wp-style danger button-large button-block" 
style="margin-bottom: 10px!important;background: yellow;color: #000;"
>WP Flatsome Helper Studio</button>`;
            let tempElement = document.createElement('div');
            tempElement.innerHTML = newButtonHTML;
            let parentElement = flatsomeButton.parentNode;
            parentElement.insertBefore(tempElement.firstChild, flatsomeButton);
        }
    }

    buttonIframeClick() {
        var wpfhIframe = `<div id="wpfh-iframe" class="flatsome-studio">
      <iframe class="flatsome-studio__iframe" frameborder="0" src="${wpfhIframeURL}/flatsome-element"></iframe>
      <button id="wpfh-close-iframe" class="flatsome-studio__close" >×</button>
    </div>`;
        var tempElement = document.createElement('div');
        tempElement.innerHTML = wpfhIframe;
        document.body.appendChild(tempElement.firstChild);
    }
}

new WPFlatsomeHelperStudio();
