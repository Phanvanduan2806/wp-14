class WpFlatsomeHelperAjax {
    static async fetchWpfhDeleteUseIn(data) {
        try {
            const response = await fetch("/wp-json/wpfh/v1/delete-use-in", {
                headers: {
                    "content-type": "application/json",
                },
                body: JSON.stringify(data),
                method: "POST",
            });
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.statusText);
            }
            return await response.json();
        } catch (error) {
            console.error('There has been a problem with your fetch operation:', error);
            throw error;
        }
    }
    static async fetchWpfhMergeCode(data) {
        try {
            const response = await fetch("/wp-json/wpfh/v1/merge-code", {
                headers: {
                    "content-type": "application/json",
                },
                body: JSON.stringify(data),
                method: "POST",
            });
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.statusText);
            }
            return await response.json();
        } catch (error) {
            console.error('There has been a problem with your fetch operation:', error);
            throw error;
        }
    }
    static async fetchWpfhPostsCategory(data) {
        try {
            const response = await fetch("/wp-json/wpfh/v1/posts-category", {
                headers: {
                    "content-type": "application/json",
                },
                body: JSON.stringify(data),
                method: "POST",
            });
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.statusText);
            }
            return await response.json();
        } catch (error) {
            console.error('There has been a problem with your fetch operation:', error);
            throw error;
        }
    }
    static async fetchWpfhInsertBlock(data) {
        try {
            const response = await fetch("/wp-json/wpfh/v1/insert-block", {
                headers: {
                    "content-type": "application/json",
                },
                body: JSON.stringify(data),
                method: "POST",
            });
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.statusText);
            }
            return await response.json();
        } catch (error) {
            console.error('There has been a problem with your fetch operation:', error);
            throw error;
        }
    }
    static async fetchDownloadImg({url, id}) {
        const requestBody = `action=ux_builder_import_media&url=${encodeURIComponent(url)}&id=${id}`;
        try {
            const response = await fetch("/wp-admin/admin-ajax.php", {
                headers: {
                    "content-type": "application/x-www-form-urlencoded; charset=UTF-8",
                    "x-requested-with": "XMLHttpRequest"
                },
                body: requestBody,
                method: "POST",
                credentials: "include"
            });
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.statusText);
            }
            return await response.json();
        } catch (error) {
            console.error('There has been a problem with your fetch operation:', error);
            throw error;
        }
    }

    static async fetchProductWithAcf(product_id) {
        const url = `${wpfhIframeURL}wp-json/wp/v2/product-acf`;
        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({product_id, token: wpfhIframeToken})
            });

            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.statusText);
            }

            return await response.json();
        } catch (error) {
            console.error('There has been a problem with your fetch operation:', error);
            throw error;
        }
    }
}
