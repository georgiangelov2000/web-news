// Make sure jQuery and slick.min.js are loaded before this script

$(document).ready(function () {

  // Helper: Show toast or alert
  function showMessage(msg, type = "success") {
    // You can integrate with Bootstrap Toast, Snackbar, etc.
    // For now, use alert as fallback
    if (window.bootstrap && $("#main-toast").length) {
      $("#main-toast .toast-body").text(msg);
      $("#main-toast").removeClass("bg-success bg-danger bg-warning");
      $("#main-toast").addClass("bg-" + type);
      $("#main-toast").toast("show");
    } else {
      alert(msg);
    }
  }

  // Favorite/Unfavorite
  $(document).on('click', '.btn-post-favorite', function (e) {
    e.preventDefault();
    let $btn = $(this);
    let postId = $btn.data('post-id');
    console.log('Favorite button clicked for post ID:', postId);
    $.ajax({
      url: '/api/posts/' + postId + '/favorite',
      type: 'POST',
      dataType: 'json',
      success: function (resp) {
        console.log('Response:', resp);
        if (resp.favorited) {
          $btn.addClass('active');
          $btn.attr('title', 'Remove from Favorites');
          $btn.find('i').addClass('bi-star-fill text-warning').removeClass('bi-star');
        } else {
          $btn.removeClass('active');
          $btn.attr('title', 'Add to Favorites');
          $btn.find('i').removeClass('bi-star-fill text-warning').addClass('bi-star');
        }
      },
      error: function (error) {
        console.error('Error:', error);
      }
    });
  });


  // Like
  $(document).on('click', '.btn-post-like', function (e) {
    e.preventDefault();
    let $btn = $(this);
    let postId = $btn.data('post-id');
    $.ajax({
      url: '/api/posts/' + postId + '/like',
      type: 'POST',
      dataType: 'json',
      success: function (resp) {
        $btn.addClass('active');
        $('.btn-post-dislike[data-post-id="' + postId + '"]').removeClass('active');
        showMessage('You liked this post!', "success");
      },
      error: function () {
        showMessage('Could not like post. Try again.', "danger");
      }
    });
  });

  // Dislike
  $(document).on('click', '.btn-post-dislike', function (e) {
    e.preventDefault();
    let $btn = $(this);
    let postId = $btn.data('post-id');
    $.ajax({
      url: '/api/posts/' + postId + '/dislike',
      type: 'POST',
      dataType: 'json',
      success: function (resp) {
        $btn.addClass('active');
        $('.btn-post-like[data-post-id="' + postId + '"]').removeClass('active');
        showMessage('You disliked this post.', "warning");
      },
      error: function () {
        showMessage('Could not dislike post. Try again.', "danger");
      }
    });
  });

  // Report
  $(document).on('click', '.btn-post-report', function (e) {
    e.preventDefault();
    let $btn = $(this);
    let postId = $btn.data('post-id');
    if (!confirm("Report this post as inappropriate?")) return;
    $.ajax({
      url: '/api/posts/' + postId + '/report',
      type: 'POST',
      dataType: 'json',
      data: { reason: 'Inappropriate content' },
      success: function (resp) {
        showMessage('Reported. Thank you!', "success");
      },
      error: function () {
        showMessage('Could not report post. Try again.', "danger");
      }
    });
  });



  // Share (GET, just open normally)
  $(document).on('click', '.btn-post-share', function (e) {
    // Optionally, open in modal or popup
    // e.preventDefault();
    // let postId = $(this).data('post-id');
    // $('#shareModal').modal('show').find('.modal-body').load('/api/posts/' + postId + '/share');
    // Or, just allow normal navigation
  });

  $('#comment-form').on('submit', function (e) {
    e.preventDefault();

    const $form = $(this);
    const body = $('#comment-body').val().trim();
    const url = $form.attr('action');

    if (!body) return;

    $.post(url, { body: body }, function (data) {
      if (data.success) {
        const comment = `
                <li class="comment">
                    <div class="comment-user">
                        <i class="bi bi-person-circle"></i>
                        ${escapeHtml(data.username)}
                    </div>
                    <span class="comment-date">
                        <i class="bi bi-clock"></i>
                        ${escapeHtml(data.created_at)}
                    </span>
                    <div class="comment-body">
                        ${escapeHtml(data.body).replace(/\n/g, '<br>')}
                    </div>
                </li>`;
        $('#comment-list').prepend(comment);
        $('#comment-body').val('');
      } else {
        alert(data.error || 'Something went wrong.');
      }
    }, 'json').fail(function () {
      alert('Request failed. Try again.');
    });
  });

  function escapeHtml(text) {
    return $('<div>').text(text).html();
  }

  $('.slick-slider').slick({
    prevArrow: `<button class="slick-prev slick-arrow" aria-label="Previous" type="button">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="11" fill="#fff" stroke="#e2e2e2"/>
          <path d="M14 7l-5 5 5 5"/>
        </svg>
      </button>`,
    nextArrow: `<button class="slick-next slick-arrow" aria-label="Next" type="button">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="11" fill="#fff" stroke="#e2e2e2"/>
          <path d="M10 7l5 5-5 5"/>
        </svg>
      </button>`,
    slidesToShow: 3,        // Number of slides to show at once
    slidesToScroll: 1,      // Number of slides to scroll per click
    arrows: true,           // Show navigation arrows
    dots: true,             // Show pagination dots
    autoplay: false,        // Set to true for automatic sliding
    autoplaySpeed: 3000,    // Delay between slides if autoplay is true
    responsive: [
      {
        breakpoint: 900,
        settings: { slidesToShow: 2 }
      },
      {
        breakpoint: 600,
        settings: { slidesToShow: 1 }
      }
    ]
  });




});