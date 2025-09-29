/**
 * Main JavaScript file for Saadibazaar Theme
 *
 * This file contains theme-specific JavaScript functionality
 * and WooCommerce enhancements.
 *
 * @package Saadibazaar_Theme
 * @since 1.0.0
 */

(function ($) {
  "use strict";

  // Theme initialization
  var SaadibazaarTheme = {
    /**
     * Initialize theme functionality
     */
    init: function () {
      this.mobileMenu();
      this.smoothScroll();
      this.backToTop();
      this.wooCommerceEnhancements();
      this.imageGallery();
      this.loadingStates();
    },

    /**
     * Mobile menu functionality
     */
    mobileMenu: function () {
      // Create mobile menu toggle button
      if (!$(".mobile-menu-toggle").length) {
        $(".main-navigation").before(
          '<button class="mobile-menu-toggle" aria-label="Toggle Menu"><span></span><span></span><span></span></button>'
        );
      }

      // Toggle mobile menu
      $(".mobile-menu-toggle").on("click", function () {
        $(this).toggleClass("active");
        $(".main-navigation").toggleClass("mobile-active");
        $("body").toggleClass("mobile-menu-open");
      });

      // Close mobile menu when clicking outside
      $(document).on("click", function (e) {
        if (
          !$(e.target).closest(".main-navigation, .mobile-menu-toggle").length
        ) {
          $(".mobile-menu-toggle").removeClass("active");
          $(".main-navigation").removeClass("mobile-active");
          $("body").removeClass("mobile-menu-open");
        }
      });
    },

    /**
     * Smooth scrolling for anchor links
     */
    smoothScroll: function () {
      $('a[href*="#"]:not([href="#"])').click(function () {
        if (
          location.pathname.replace(/^\//, "") ==
            this.pathname.replace(/^\//, "") &&
          location.hostname == this.hostname
        ) {
          var target = $(this.hash);
          target = target.length
            ? target
            : $("[name=" + this.hash.slice(1) + "]");
          if (target.length) {
            $("html, body").animate(
              {
                scrollTop: target.offset().top - 80,
              },
              800
            );
            return false;
          }
        }
      });
    },

    /**
     * Back to top button
     */
    backToTop: function () {
      // Add back to top button
      if (!$(".back-to-top").length) {
        $("body").append(
          '<button class="back-to-top" aria-label="Back to Top">↑</button>'
        );
      }

      // Show/hide on scroll
      $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
          $(".back-to-top").fadeIn();
        } else {
          $(".back-to-top").fadeOut();
        }
      });

      // Scroll to top on click
      $(".back-to-top").click(function () {
        $("html, body").animate({ scrollTop: 0 }, 800);
        return false;
      });
    },

    /**
     * WooCommerce specific enhancements
     */
    wooCommerceEnhancements: function () {
      // Product gallery
      $(".woocommerce-product-gallery").each(function () {
        $(this)
          .find("img")
          .on("click", function () {
            var src = $(this).attr("src");
            var alt = $(this).attr("alt");

            // Simple lightbox effect
            var lightbox =
              '<div class="product-lightbox"><div class="lightbox-content"><img src="' +
              src +
              '" alt="' +
              alt +
              '"><button class="lightbox-close">×</button></div></div>';
            $("body").append(lightbox);

            $(".product-lightbox").fadeIn();
          });
      });

      // Close lightbox
      $(document).on(
        "click",
        ".lightbox-close, .product-lightbox",
        function (e) {
          if (e.target === this) {
            $(".product-lightbox").fadeOut(function () {
              $(this).remove();
            });
          }
        }
      );

      // Quantity input enhancements
      $(".woocommerce").on(
        "click",
        ".quantity .plus, .quantity .minus",
        function () {
          var $qty = $(this).siblings(".qty");
          var currentVal = parseInt($qty.val());
          var max = parseInt($qty.attr("max"));
          var min = parseInt($qty.attr("min"));
          var step = parseInt($qty.attr("step"));

          if (isNaN(currentVal)) currentVal = 0;
          if (isNaN(max)) max = "";
          if (isNaN(min)) min = 0;
          if (isNaN(step)) step = 1;

          if ($(this).hasClass("plus")) {
            if (max && currentVal >= max) {
              $qty.val(max);
            } else {
              $qty.val(currentVal + step);
            }
          } else {
            if (currentVal <= min) {
              $qty.val(min);
            } else {
              $qty.val(currentVal - step);
            }
          }

          $qty.trigger("change");
        }
      );

      // Update cart automatically when quantity changes
      $(".woocommerce-cart-form").on("change", "input.qty", function () {
        var $form = $(this).closest(".woocommerce-cart-form");
        $form.addClass("loading");

        setTimeout(function () {
          $('[name="update_cart"]').click();
        }, 500);
      });

      // Add loading state to add to cart buttons
      $(".woocommerce").on("click", ".add_to_cart_button", function () {
        $(this).addClass("loading").text("Adding...");
      });
    },

    /**
     * Image gallery enhancements
     */
    imageGallery: function () {
      // Add hover effects to gallery images
      $(".wp-block-gallery img, .gallery img").hover(
        function () {
          $(this).animate({ opacity: 0.8 }, 200);
        },
        function () {
          $(this).animate({ opacity: 1 }, 200);
        }
      );
    },

    /**
     * Loading state management
     */
    loadingStates: function () {
      // Add loading spinner CSS if not exists
      if (!$("#loading-spinner-css").length) {
        var spinnerCSS = `
                <style id="loading-spinner-css">
                .loading { position: relative; pointer-events: none; opacity: 0.6; }
                .loading::after {
                    content: '';
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    width: 20px;
                    height: 20px;
                    margin: -10px 0 0 -10px;
                    border: 2px solid #f3f3f3;
                    border-top: 2px solid #2c5aa0;
                    border-radius: 50%;
                    animation: spin 1s linear infinite;
                    z-index: 999;
                }
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
                .back-to-top {
                    position: fixed;
                    bottom: 30px;
                    right: 30px;
                    background: #2c5aa0;
                    color: white;
                    border: none;
                    border-radius: 50%;
                    width: 50px;
                    height: 50px;
                    cursor: pointer;
                    display: none;
                    z-index: 999;
                    font-size: 20px;
                    transition: background-color 0.3s;
                }
                .back-to-top:hover {
                    background: #1a3b6b;
                }
                .mobile-menu-toggle {
                    display: none;
                    flex-direction: column;
                    background: none;
                    border: none;
                    cursor: pointer;
                    padding: 10px;
                }
                .mobile-menu-toggle span {
                    width: 25px;
                    height: 3px;
                    background: #333;
                    margin: 2px 0;
                    transition: 0.3s;
                }
                .product-lightbox {
                    display: none;
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0,0,0,0.8);
                    z-index: 9999;
                    justify-content: center;
                    align-items: center;
                }
                .lightbox-content {
                    position: relative;
                    max-width: 90%;
                    max-height: 90%;
                }
                .lightbox-content img {
                    max-width: 100%;
                    max-height: 100%;
                }
                .lightbox-close {
                    position: absolute;
                    top: -40px;
                    right: -40px;
                    background: white;
                    border: none;
                    border-radius: 50%;
                    width: 30px;
                    height: 30px;
                    cursor: pointer;
                    font-size: 18px;
                }
                @media (max-width: 768px) {
                    .mobile-menu-toggle {
                        display: flex;
                    }
                    .main-navigation {
                        display: none;
                    }
                    .main-navigation.mobile-active {
                        display: block;
                        position: absolute;
                        top: 100%;
                        left: 0;
                        width: 100%;
                        background: white;
                        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                        z-index: 999;
                    }
                    .main-navigation.mobile-active ul {
                        flex-direction: column;
                        padding: 20px;
                    }
                    .main-navigation.mobile-active li {
                        margin: 10px 0;
                    }
                }
                </style>`;
        $("head").append(spinnerCSS);
      }

      // Remove loading state when page is fully loaded
      $(window).on("load", function () {
        $(".loading").removeClass("loading");
      });
    },
  };

  // Initialize theme when document is ready
  $(document).ready(function () {
    SaadibazaarTheme.init();
  });

  // Additional initialization after AJAX complete (for WooCommerce)
  $(document).ajaxComplete(function () {
    SaadibazaarTheme.wooCommerceEnhancements();
  });
})(jQuery);
