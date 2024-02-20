// td[data-colname="Uses In"]
jQuery(document).ready(function ($) {
    $('td[data-colname="Uses In"]').each(function () {
        const use_in = $(this).find('a').text();
        var previewButton = $('<button/>', {
            type: 'button',
            text: 'Preview',
            class: 'button',
            click: function () {
                const url = `/wpfh_blocks_preview?use_in=${use_in}`;
                window.open(url, '_blank');
            }
        });
        var mergeButton = $('<button/>', {
            type: 'button',
            text: 'Merge',
            class: 'button button-primary',
            click: function () {
                $('#wpfh-myModal').remove();
                const modalHTML = `<div id="wpfh-myModal" class="wpfh-modal">
    <div class="wpfh-modal-content">
        <span class="wpfh-close-button">&times;</span>
        <h2>Merge Code</h2>
        <p>${use_in}</p>
        <div>
            <button id="wpfh-cancelButton" class="button">Cancel</button>
            <button id="wpfh-mergeButtonDelete" data-use_in="${use_in}" class="button button-link-delete">Delete</button>
            <button id="wpfh-mergeButton" data-use_in="${use_in}" class="button button-primary">Start merge</button>
        </div>
    </div>
</div>`;
                $("body").append(modalHTML);
                $("#wpfh-myModal").show();
            }
        });

        $(this).append(previewButton, mergeButton);
    });
});
// CANCEL BUTTON
jQuery(document).ready(function ($) {
    $("body").on("click", ".wpfh-close-button, #wpfh-cancelButton", function () {
        $("#wpfh-myModal").hide();
    });
});
// START MERGE BUTTON
jQuery(document).ready(function ($) {
    $("body").on("click", "#wpfh-mergeButton", async function () {
        $(".wpfh-modal-content").addClass('wpfh-loading');
        const use_in = $(this).data('use_in');
        const res = await WpFlatsomeHelperAjax.fetchWpfhMergeCode({use_in});
        $(".wpfh-modal-content").removeClass('wpfh-loading');
        const modalHTML = `
        <span class="wpfh-close-button">&times;</span>
        <h2>Done merge: ${use_in}</h2>
        <div>
            <button class="wpfh-copy-button">copy</button>
            <textarea rows="10">${res.enqueue_code}</textarea>
        </div>
        <div>
            <button id="wpfh-cancelButton" class="button">Close</button>
            <button id="wpfh-mergeButtonDelete" data-use_in="${use_in}" class="button button-link-delete">Delete</button>
            <button id="wpfh-mergeButtonView" data-post_id="${res.post_id}" class="button button-primary">View</button>
        </div>`;
        $(".wpfh-modal-content").html(modalHTML);
    });
});

// VIEW BUTTON
jQuery(document).ready(function ($) {
    $("body").on("click", "#wpfh-mergeButtonView", function () {
        const post_id = $(this).data('post_id');
        window.open(`/?p=${post_id}`, '_blank');
    });
});

// COPY BUTTON
jQuery(document).ready(function ($) {
    $("body").on("click", ".wpfh-copy-button", function () {
        var textarea = $(this).parent().find('textarea');
        textarea.select();
        document.execCommand("copy");
        $(this).text('copied');
    });
});

// DELETE BUTTON
jQuery(document).ready(function ($) {
    $("body").on("click", "#wpfh-mergeButtonDelete", async function () {
        const use_in = $(this).data('use_in');
        var confirmAction = confirm(`DELETE: ${use_in}`);
        if (!confirmAction) {
            e.preventDefault();
        }
        const res = await WpFlatsomeHelperAjax.fetchWpfhDeleteUseIn({use_in});
        if (res.count_delete) {
            window.location.reload();
        }
    });
});

