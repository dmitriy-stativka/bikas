/*!
 * Variation Swatches for WooCommerce - PRO 
 * 
 * Author: Emran Ahmed ( emran.bd.08@gmail.com ) 
 * Date: 6/16/2022, 4:46:06 PM
 * Released under the GPLv3 license.
 */
/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/js/WooVariationSwatchesPro.js":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

/*global _, wp, wc_add_to_cart_variation_params, woo_variation_swatches_pro_params, woo_variation_swatches_pro_options */

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

var WooVariationSwatchesPro = function ($) {
  return /*#__PURE__*/function () {
    function _class2(element, options) {
      var _this = this;

      _classCallCheck(this, _class2);

      _defineProperty(this, "defaults", {});

      _defineProperty(this, "onInit", function (event) {
        _this.init();
      });

      _defineProperty(this, "onExpandVariableItems", function (event) {
        event.preventDefault();

        _this.expandVariableItems(event);
      });

      _defineProperty(this, "onPreviewChange", function (event) {
        event.preventDefault();

        _this.$element.off('reset_data.wc-variation-form');

        _this.previewChange(event.currentTarget);
      });

      _defineProperty(this, "onChange", function (event) {
        // this.$element.find('input[name="variation_id"], input.variation_id').val('').trigger('change')
        // this.$element.find('.wc-no-matching-variations').remove()
        _this.$element.trigger('woocommerce_variation_select_change');

        _this.$element.trigger('check_variations'); // Custom event for when variation selection has been changed


        _this.$element.trigger('woocommerce_variation_has_changed');
      });

      _defineProperty(this, "onReset", function (event) {
        event.preventDefault();

        _this.reset();
      });

      _defineProperty(this, "onResetDisplayedVariation", function (event) {
        _this.resetDisplayedVariation();
      });

      _defineProperty(this, "onUpdateAttributes", function (event) {
        _this.updateAttributes(event);
      });

      _defineProperty(this, "onCheckVariations", function (event) {
        _this.checkVariations();
      });

      _defineProperty(this, "onVariationChanged", function (event) {
        _this.setupSwatchesItems();
      });

      _defineProperty(this, "onFoundVariation", function (event, variation, is_ajax) {
        _this.foundVariation(variation, is_ajax);
      });

      // Properties
      this._element = element;
      this.$element = $(element);
      this.settings = $.extend(true, {}, this.defaults, options);
      this.product_variations = this.$element.data('product_variations') || [];
      this.is_ajax_variation = this.product_variations.length < 1;
      this.product_id = parseInt(this.$element.data('product_id'), 10);
      this.threshold_min = parseInt(this.$element.data('threshold_min'), 10);
      this.threshold_max = parseInt(this.$element.data('threshold_max'), 10);
      this.total_children = parseInt(this.$element.data('total_children'), 10);
      this.xhr = false;
      this.previewXhr = false;
      this.loading = true;
      this.$information = this.$element.find('.wvs-archive-information');
      this.$wrapper = this.$element.closest(woo_variation_swatches_pro_options.archive_product_wrapper);
      this.$image = this.$wrapper.find(woo_variation_swatches_pro_options.archive_image_selector);
      this.$cart_button = this.$wrapper.find(woo_variation_swatches_pro_options.archive_cart_button_selector);
      this.$price = this.$wrapper.find('.price');
      this.$firstUL = this.$element.find('.variations ul:first');
      this.$cart_button_html = this.$cart_button.clone().html();
      this.$price_html = this.$price.clone().html();
      this.$attributeFields = this.$element.find('.variations select');
      this.$resetVariations = this.$element.find('.wvs_archive_reset_variations');
      var single_variation_preview_selector = false;

      if (woo_variation_swatches_pro_options.enable_single_variation_preview && woo_variation_swatches_pro_options.enable_single_variation_preview_archive) {
        var name = this.$firstUL.data('preview_attribute_name') ? this.$firstUL.data('preview_attribute_name') : this.$attributeFields.first().data('attribute_name');
        single_variation_preview_selector = ".variations select[data-attribute_name='".concat(name, "']");
      } // Initial state.


      this.$element.off('.wc-variation-form');
      this.$element.addClass('wvs-pro-loaded'); // Events

      this.$element.on('click.wc-variation-form', '.wvs_archive_reset_variations > a', this.onReset);
      this.$element.on('change.wc-variation-form', '.variations select', this.onChange);
      this.$element.on('check_variations.wc-variation-form', this.onCheckVariations);
      this.$element.on('update_variation_values.wc-variation-form', this.onUpdateAttributes);
      this.$element.on('found_variation.wc-variation-form', this.onFoundVariation);
      this.$element.on('reset_data.wc-variation-form', this.onResetDisplayedVariation);
      this.$element.on('woocommerce_variation_has_changed.wc-variation-form', this.onVariationChanged);

      if (!woo_variation_swatches_pro_options.enable_catalog_mode && woo_variation_swatches_pro_options.enable_single_variation_preview && woo_variation_swatches_pro_options.enable_single_variation_preview_archive) {
        this.$element.on('click.wc-variation-form', '.wvs_archive_reset_variations > a', this.onResetDisplayedVariation);
        this.$element.on('change.wc-variation-form', single_variation_preview_selector, this.onPreviewChange);
      }

      if ('expand' === woo_variation_swatches_pro_options.catalog_mode_behaviour) {
        this.$element.on('click.wc-variation-form', '.woo-variation-swatches-variable-item-more', this.onExpandVariableItems);
      }

      this.$element.on('woo_variation_swatches_init.wc-variation-form', this.onInit);
      this.$element.trigger('woo_variation_swatches_init', this);
    }

    _createClass(_class2, [{
      key: "start",
      value: function start() {
        var _this2 = this;

        // Init after gallery.
        setTimeout(function () {
          _this2.$element.trigger('check_variations');

          _this2.$element.trigger('wc_variation_form', _this2);

          _this2.swatchInit();
        }, 100);
      }
    }, {
      key: "expandVariableItems",
      value: function expandVariableItems(event) {
        $(event.currentTarget).parent().removeClass('enabled-display-limit-mode enabled-catalog-display-limit-mode');
        $(event.currentTarget).remove();
      }
    }, {
      key: "init",
      value: function init() {
        var _this3 = this;

        var limit = this.threshold_max;
        var total = this.total_children; // The Logic
        // threshold_min = 30
        // threshold_max = 200
        // total_children = 20
        // then load by html attr
        //
        // threshold_min = 30
        // threshold_max = 200
        // total_children = 100
        // then load all variations by ajax
        //
        // threshold_min = 30
        // threshold_max = 200
        // total_children = 500
        // then load selected variations only via ajax
        // Store default image

        this.defaultImage();
        this.defaultCartButton();

        if (this.isAjaxVariation() && limit >= total) {
          if (this.xhr) {
            this.xhr.abort();
          }

          this.$element.block({
            message: null,
            overlayCSS: {
              background: '#FFFFFF',
              opacity: 0.6
            }
          });
          this.xhr = $.ajax({
            global: false,
            url: woo_variation_swatches_pro_params.wc_ajax_url.toString().replace('%%endpoint%%', 'woo_get_variations'),
            method: 'POST',
            data: {
              product_id: this.product_id,
              is_archive: true
            }
          });
          this.xhr.fail(function (jqXHR, textStatus) {
            console.error("product variations not available on: ".concat(_this3.product_id, "."), textStatus);
          });
          this.xhr.done(function (variations) {
            if (variations) {
              _this3.$element.data('product_variations', variations);

              _this3.product_variations = _this3.$element.data('product_variations');
              _this3.is_ajax_variation = false;

              _this3.start();
            }
          });
          this.xhr.always(function () {
            _this3.$element.unblock();
          });
        } else {
          this.start();
        }
      }
    }, {
      key: "previewChange",
      value: function previewChange(el) {
        var _this4 = this;

        var attribute_name = $(el).data('attribute_name') || $(el).attr('name');
        var value = $(el).val() || '';
        var currentAttributes = {};
        var attributes = this.getChosenAttributes();

        if (value && attributes.count && attributes.count > attributes.chosenCount) {
          currentAttributes['product_id'] = this.product_id;
          currentAttributes[attribute_name] = value;
          this.previewXhr = $.ajax({
            global: false,
            url: woo_variation_swatches_pro_params.wc_ajax_url.toString().replace('%%endpoint%%', 'woo_get_preview_variation'),
            method: 'POST',
            data: currentAttributes
          });
          this.previewXhr.fail(function (jqXHR, textStatus) {
            console.error("archive product preview not available on ".concat(_this4.product_id, "."), attribute_name, textStatus);
          });
          this.previewXhr.done(function (variation) {
            // console.log(variation)
            _this4.updatePreviewImage(variation);
          });
        }
      }
    }, {
      key: "getAvailableVariations",
      value: function getAvailableVariations() {
        return this.$element.data('product_variations') || [];
      }
    }, {
      key: "toggleResetLink",
      value: function toggleResetLink(show) {
        if (show) {
          this.$resetVariations.removeClass('show hide').addClass('show');
        } else {
          this.$resetVariations.removeClass('show hide').addClass('hide');
        }
      }
    }, {
      key: "reset",
      value: function reset() {
        this.$attributeFields.val('').trigger('change');
        this.$element.trigger('reset_data');
      }
    }, {
      key: "getChosenAttributes",
      value: function getChosenAttributes() {
        var data = {};
        var count = 0;
        var chosen = 0;
        this.$attributeFields.each(function () {
          var attribute_name = $(this).data('attribute_name') || $(this).attr('name');
          var value = $(this).val() || '';

          if (value.length > 0) {
            chosen++;
          }

          count++;
          data[attribute_name] = value;
        });
        return {
          'count': count,
          'chosenCount': chosen,
          'data': data
        };
      }
    }, {
      key: "isMatch",
      value: function isMatch(variation_attributes, attributes) {
        var match = true;

        for (var attr_name in variation_attributes) {
          if (variation_attributes.hasOwnProperty(attr_name)) {
            var val1 = variation_attributes[attr_name];
            var val2 = attributes[attr_name];

            if (val1 !== undefined && val2 !== undefined && val1.length !== 0 && val2.length !== 0 && val1 !== val2) {
              match = false;
            }
          }
        }

        return match;
      }
    }, {
      key: "findMatchingVariations",
      value: function findMatchingVariations(variations, attributes) {
        var matching = [];

        for (var i = 0; i < variations.length; i++) {
          var variation = variations[i];

          if (this.isMatch(variation.attributes, attributes)) {
            matching.push(variation);
          }
        }

        return matching;
      }
    }, {
      key: "updateAttributes",
      value: function updateAttributes(event) {
        var _this5 = this;

        var attributes = this.getChosenAttributes();
        var currentAttributes = attributes.data;

        if (this.isAjaxVariation()) {
          return;
        } // Loop through selects and disable/enable options based on selections.


        this.$attributeFields.each(function (index, el) {
          var current_attr_select = $(el),
              current_attr_name = current_attr_select.data('attribute_name') || current_attr_select.attr('name'),
              show_option_none = $(el).data('show_option_none'),
              option_gt_filter = ':gt(0)',
              attached_options_count = 0,
              new_attr_select = $('<select/>'),
              selected_attr_val = current_attr_select.val() || '',
              selected_attr_val_valid = true; // Reference options set at first.

          if (!current_attr_select.data('attribute_html')) {
            var refSelect = current_attr_select.clone(); // refSelect.find('option').removeAttr('disabled attached').removeAttr('selected')

            refSelect.find('option').prop('disabled', false).prop('selected', false).removeAttr('attached').removeClass('out-of-stock'); // current_attr_select.data('attribute_options', refSelect.find('option' + option_gt_filter).get()) // Legacy data attribute.

            current_attr_select.data('attribute_html', refSelect.html());
          }

          new_attr_select.html(current_attr_select.data('attribute_html')); // The attribute of this select field should not be taken into account when calculating its matching variations:
          // The constraints of this attribute are shaped by the values of the other attributes.

          var checkAttributes = $.extend(true, {}, currentAttributes);
          checkAttributes[current_attr_name] = '';

          var variations = _this5.findMatchingVariations(_this5.getAvailableVariations(), checkAttributes); // Loop through variations.


          for (var num in variations) {
            if (typeof variations[num] !== 'undefined') {
              var variationAttributes = variations[num].attributes;

              for (var attr_name in variationAttributes) {
                if (variationAttributes.hasOwnProperty(attr_name)) {
                  var attr_val = variationAttributes[attr_name];
                  var variation_active = '';
                  var variation_out_of_stock = false;

                  if (attr_name === current_attr_name) {
                    if (variations[num].variation_is_active) {
                      variation_active = 'enabled';
                    } // Out Of Stock Class


                    if (!variations[num].is_in_stock) {
                      variation_out_of_stock = true;
                    }

                    if (attr_val) {
                      // Decode entities and add slashes.
                      attr_val = $('<div/>').html(attr_val).text(); // Attach.
                      // new_attr_select.find('option[value="' + form.addSlashes(attr_val) + '"]').addClass('attached ' + variation_active);
                      // Attach to matching options by value. This is done to compare
                      // TEXT values rather than any HTML entities.

                      var $option_elements = new_attr_select.find('option');

                      if ($option_elements.length) {
                        for (var i = 0, len = $option_elements.length; i < len; i++) {
                          var $option_element = $($option_elements[i]);
                          var option_value = $option_element.val(); // @TODO: WORK HERE

                          if (attr_val === option_value) {
                            $option_element.addClass('attached ' + variation_active); // 1+ attributes, 1+ selected then non selected show out of stock

                            if (attributes.count > 1 && attributes.chosenCount > 0 && !selected_attr_val && variation_out_of_stock) {
                              $option_element.addClass('out-of-stock');
                            } // 1+ attributes and all selected


                            if (attributes.count > 1 && attributes.chosenCount === attributes.count && variation_out_of_stock) {
                              $option_element.addClass('out-of-stock');
                            } // 1 attribute except catalog mode


                            if (!woo_variation_swatches_pro_options.enable_catalog_mode && attributes.count === 1 && variation_out_of_stock) {
                              $option_element.addClass('out-of-stock');
                            }

                            break;
                          }
                        }
                      }
                    } else {
                      // Attach all apart from placeholder.
                      new_attr_select.find('option:gt(0)').addClass('attached ' + variation_active);
                    }
                  }
                }
              }
            }
          } // Count available options.


          attached_options_count = new_attr_select.find('option.attached').length; // Check if current selection is in attached options.

          if (selected_attr_val) {
            selected_attr_val_valid = false;

            if (0 !== attached_options_count) {
              new_attr_select.find('option.attached.enabled').each(function () {
                var option_value = $(this).val();

                if (selected_attr_val === option_value) {
                  selected_attr_val_valid = true;
                  return false; // break.
                }
              });
            }
          } // Detach the placeholder if:
          // - Valid options exist.
          // - The current selection is non-empty.
          // - The current selection is valid.
          // - Placeholders are not set to be permanently visible.


          if (attached_options_count > 0 && selected_attr_val && selected_attr_val_valid && 'no' === show_option_none) {
            new_attr_select.find('option:first').remove();
            option_gt_filter = '';
          } // Detach unattached.


          new_attr_select.find('option' + option_gt_filter + ':not(.attached)').remove(); // for out of stock
          // new_attr_select.find('option' + option_gt_filter + ':not(.attached):not(.out-of-stock)').remove()
          // Finally, copy to DOM and set value.

          current_attr_select.html(new_attr_select.html());
          current_attr_select.find('option' + option_gt_filter + ':not(.enabled)').prop('disabled', true); ////current_attr_select.find('option' + option_gt_filter + ':not(.enabled):not(.out-of-stock)').prop('disabled', true)
          //current_attr_select.find('option' + option_gt_filter + ':not(.enabled)').addClass('out-of-stock')
          // Choose selected value.

          if (selected_attr_val) {
            // If the previously selected value is no longer available, fall back to the placeholder (it's going to be there).
            if (selected_attr_val_valid) {
              current_attr_select.val(selected_attr_val);
            } else {
              // current_attr_select.val('').change()
              current_attr_select.val('').trigger('change');
            }
          } else {
            current_attr_select.val(''); // No change event to prevent infinite loop.
          }
        }); // Custom event for when variations have been updated.

        this.$element.trigger('woocommerce_update_variation_values');
      }
    }, {
      key: "checkVariations",
      value: function checkVariations() {
        var _this6 = this;

        var chosenAttributes = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
        var attributes = chosenAttributes ? chosenAttributes : this.getChosenAttributes();
        var currentAttributes = attributes.data;

        if (attributes.count && attributes.count === attributes.chosenCount) {
          if (this.isAjaxVariation()) {
            // attributes based attr
            if (this.xhr) {
              this.xhr.abort();
            }

            this.$element.block({
              message: null,
              overlayCSS: {
                background: '#FFFFFF',
                opacity: 0.6
              }
            });
            currentAttributes.product_id = this.product_id;
            currentAttributes.custom_data = this.$element.data('custom_data');
            this.xhr = $.ajax({
              global: false,
              url: woo_variation_swatches_pro_params.wc_ajax_url.toString().replace('%%endpoint%%', 'woo_get_variation'),
              method: 'POST',
              data: currentAttributes
            });
            this.xhr.fail(function (jqXHR, textStatus) {
              console.error("product variations not available on ".concat(_this6.product_id, "."), textStatus);
            });
            this.xhr.done(function (variation) {
              if (variation) {
                _this6.$element.trigger('found_variation', [variation, true]);
              } else {
                _this6.$element.trigger('reset_data');

                attributes.chosenCount = 0;
              }
            });
            this.xhr.always(function () {
              _this6.$element.unblock();
            });
          } else {
            // by html attr
            this.$element.trigger('update_variation_values');
            var variations = this.getAvailableVariations();
            var matching_variations = this.findMatchingVariations(variations, currentAttributes);
            var variation = matching_variations.shift();

            if (variation) {
              this.$element.trigger('found_variation', [variation, false]);
            } else {
              this.$element.trigger('reset_data');
              attributes.chosenCount = 0;
            }
          }
        } else {
          this.$element.trigger('update_variation_values');
          this.$element.trigger('reset_data');
        } // Show reset link.


        this.toggleResetLink(attributes.chosenCount > 0);
      }
    }, {
      key: "isAjaxVariation",
      value: function isAjaxVariation() {
        return this.is_ajax_variation;
      }
    }, {
      key: "swatchInit",
      value: function swatchInit() {
        this.setupSwatchesItems();
        this.setupSwatchesEvents();
      }
    }, {
      key: "setupSwatchesItems",
      value: function setupSwatchesItems() {
        var _this7 = this;

        var self = this;
        this.$element.find('ul.variable-items-wrapper').each(function (i, element) {
          var selected = '';
          var select = $(element).parent().find('select.woo-variation-raw-select');
          var options = select.find('option');
          var disabled = select.find('option:disabled');
          var out_of_stock = select.find('option.enabled.out-of-stock');
          var current = select.find('option:selected');
          var eq = select.find('option').eq(1);
          var selects = [];
          var disabled_selects = [];
          var out_of_stocks = []; // All Options

          options.each(function () {
            if ($(this).val() !== '') {
              selects.push($(this).val());
              selected = current.length === 0 ? eq.val() : current.val();
            }
          }); // Disabled

          disabled.each(function () {
            if ($(this).val() !== '') {
              disabled_selects.push($(this).val());
            }
          }); // Out Of Stocks

          out_of_stock.each(function () {
            if ($(this).val() !== '') {
              out_of_stocks.push($(this).val());
            }
          });

          var in_stocks = _.difference(selects, disabled_selects);

          _this7.setupSwatchesItem(element, selected, in_stocks, out_of_stocks);
        });
      }
    }, {
      key: "setupSwatchesItem",
      value: function setupSwatchesItem(element, selected, in_stocks, out_of_stocks) {
        var _this8 = this;

        // Mark Selected
        $(element).find('li.variable-item').each(function (index, el) {
          var attribute_value = $(el).attr('data-value');
          var attribute_title = $(el).attr('data-title'); // Resetting LI

          $(el).removeClass('selected disabled no-stock').addClass('disabled');
          $(el).attr('aria-checked', 'false');
          $(el).attr('tabindex', '-1');
          $(el).attr('data-wvstooltip-out-of-stock', '');
          $(el).find('input.variable-item-radio-input:radio').prop('disabled', true).prop('checked', false); // Ajax variation

          if (_this8.isAjaxVariation()) {
            $(el).find('input.variable-item-radio-input:radio').prop('disabled', false);
            $(el).removeClass('selected disabled no-stock'); // Selected

            if (attribute_value === selected) {
              $(el).addClass('selected');
              $(el).attr('aria-checked', 'true');
              $(el).attr('tabindex', '0');
              $(el).find('input.variable-item-radio-input:radio').prop('disabled', false).prop('checked', true);
              $(el).trigger('wvs-item-updated', [selected, attribute_value]);
            }
          } else {
            // Default Selected
            // We can't use es6 includes for IE11
            // in_stocks.includes(attribute_value)
            // _.contains(in_stocks, attribute_value)
            // _.includes(in_stocks, attribute_value)
            if (_.includes(in_stocks, attribute_value)) {
              $(el).removeClass('selected disabled');
              $(el).removeAttr('aria-hidden');
              $(el).attr('tabindex', '0');
              $(el).find('input.variable-item-radio-input:radio').prop('disabled', false); // Selected

              if (attribute_value === selected) {
                $(el).addClass('selected');
                $(el).attr('aria-checked', 'true');
                $(el).find('input.variable-item-radio-input:radio').prop('checked', true);
                $(el).trigger('wvs-item-updated', [selected, attribute_value]);
              }
            } // Out of Stock


            if (_.includes(out_of_stocks, attribute_value) && woo_variation_swatches_pro_options.clickable_out_of_stock) {
              $(el).removeClass('disabled').addClass('no-stock');
              $(el).attr('data-wvstooltip-out-of-stock', woo_variation_swatches_pro_options.out_of_stock_tooltip_text);
            }
          }
        });
      }
    }, {
      key: "setupSwatchesEvents",
      value: function setupSwatchesEvents() {
        var _this9 = this;

        var self = this;
        this.$element.find('ul.variable-items-wrapper').each(function (i, element) {
          var select = $(element).parent().find('select.woo-variation-raw-select'); // Trigger Select event based on list

          if (woo_variation_swatches_pro_options.clear_on_reselect) {
            // Non Selected Item Should Select
            $(element).on('click.wvs', 'li.variable-item:not(.selected):not(.radio-variable-item)', function (event) {
              event.preventDefault();
              event.stopPropagation();
              var value = $(this).data('value');
              select.val(value).trigger('change');
              select.trigger('click'); // select.trigger('focusin')

              if (woo_variation_swatches_pro_options.is_mobile) {//     select.trigger('touchstart')
              } // $(this).trigger('focus') // Mobile tooltip


              $(this).trigger('wvs-selected-item', [value, select, self.$element]); // Custom Event for li
            }); // Selected Item Should un Select

            $(element).on('click.wvs', 'li.variable-item.selected:not(.radio-variable-item)', function (event) {
              event.preventDefault();
              event.stopPropagation();
              var value = $(this).val();

              if (woo_variation_swatches_pro_options.enable_catalog_mode && 'hover' === woo_variation_swatches_pro_options.catalog_mode_trigger) {
                return false;
              }

              select.val('').trigger('change');
              select.trigger('click');
              $(this).trigger('wvs-unselected-item', [value, select, self.$element]); // Custom Event for li
            }); // RADIO
            // On Click trigger change event on Radio button

            $(element).on('click.wvs', 'input.variable-item-radio-input:radio', function (event) {
              event.stopPropagation();
              $(this).trigger('change.wvs', {
                radioChange: true
              });
            });
            $(element).on('change.wvs', 'input.variable-item-radio-input:radio', function (event, params) {
              event.preventDefault();
              event.stopPropagation();

              if (params && params.radioChange) {
                var value = $(this).val();
                var is_selected = $(this).parent('li.radio-variable-item').hasClass('selected');

                if (is_selected) {
                  select.val('').trigger('change');
                  $(this).parent('li.radio-variable-item').trigger('wvs-unselected-item', [value, select, self.$element]); // Custom Event for li
                } else {
                  select.val(value).trigger('change');
                  $(this).parent('li.radio-variable-item').trigger('wvs-selected-item', [value, select, self.$element]); // Custom Event for li
                }

                select.trigger('click'); //select.trigger('focusin')

                if (woo_variation_swatches_pro_options.is_mobile) {//    select.trigger('touchstart')
                }
              }
            });
          } else {
            $(element).on('click.wvs', 'li.variable-item:not(.radio-variable-item)', function (event) {
              event.preventDefault();
              event.stopPropagation();
              var value = $(this).data('value');
              select.val(value).trigger('change');
              select.trigger('click'); // select.trigger('focusin')

              if (woo_variation_swatches_pro_options.is_mobile) {//   select.trigger('touchstart')
              } // $(this).trigger('focus') // Mobile tooltip


              $(this).trigger('wvs-selected-item', [value, select, self._element]); // Custom Event for li
            }); // Radio

            $(element).on('change.wvs', 'input.variable-item-radio-input:radio', function (event) {
              event.preventDefault();
              event.stopPropagation();
              var value = $(this).val();
              select.val(value).trigger('change');
              select.trigger('click'); // select.trigger('focusin')

              if (woo_variation_swatches_pro_options.is_mobile) {//   select.trigger('touchstart')
              } // Radio


              $(this).parent('li.radio-variable-item').removeClass('selected disabled no-stock').addClass('selected');
              $(this).parent('li.radio-variable-item').trigger('wvs-selected-item', [value, select, self.$element]); // Custom Event for li
            });
          } // Keyboard Access


          $(element).on('keydown.wvs', 'li.variable-item:not(.disabled)', function (event) {
            if (event.keyCode && 32 === event.keyCode || event.key && ' ' === event.key || event.keyCode && 13 === event.keyCode || event.key && 'enter' === event.key.toLowerCase()) {
              event.preventDefault();
              $(this).trigger('click');
            }
          });

          if (!woo_variation_swatches_pro_options.is_mobile && woo_variation_swatches_pro_options.enable_catalog_mode && 'hover' === woo_variation_swatches_pro_options.catalog_mode_trigger) {
            if (_this9.threshold_max < _this9.total_children) {
              $(element).on('mouseenter.wvs', 'li.variable-item:not(.radio-variable-item)', function () {
                $(this).trigger('click');
                $(element).off('mouseenter.wvs');
              });
            } else {
              $(element).on('mouseenter.wvs', 'li.variable-item:not(.radio-variable-item)', function (event) {
                $(this).trigger('click');
              });
            } // linkable_attribute


            if (woo_variation_swatches_pro_options.linkable_attribute) {
              $(element).on('click.linkable', 'li.variable-item:not(.radio-variable-item)', function (event) {
                if ('undefined' !== typeof event.originalEvent) {
                  var url = $(this).attr('data-url');
                  url ? window.location.href = url : '';
                }
              });
            }
          }
        });
      } // End ---

    }, {
      key: "resetDisplayedVariation",
      value: function resetDisplayedVariation() {
        this.resetPrice();
        this.resetImage();
        this.resetAvailabilityInfo();
        this.resetCartButton();
      }
    }, {
      key: "foundVariation",
      value: function foundVariation(variation, is_ajax) {
        var purchasable = true;
        var template;
        var $template_html; // this.getVariation(variation, is_ajax)

        this.updateImage(variation);
        this.reAttachCatalogModeHover();

        if (!woo_variation_swatches_pro_options.enable_catalog_mode) {
          this.updateAvailabilityInfo(variation);
          this.updatePrice(variation);
        } // Enable or disable the add to cart button


        if (!variation.is_purchasable || !variation.is_in_stock || !variation.variation_is_visible) {
          purchasable = false;
        }

        if (purchasable && !woo_variation_swatches_pro_options.enable_catalog_mode) {
          this.updateCartButton(variation);
        } else {
          this.resetCartButton();
        }

        this.$element.trigger('show_variation', [variation, purchasable]);
      }
    }, {
      key: "reAttachCatalogModeHover",
      value: function reAttachCatalogModeHover() {
        if (!woo_variation_swatches_pro_options.is_mobile && this.threshold_max < this.total_children && woo_variation_swatches_pro_options.enable_catalog_mode && 'hover' === woo_variation_swatches_pro_options.catalog_mode_trigger) {
          this.$element.find('ul.variable-items-wrapper').each(function (i, element) {
            $(element).one('mouseenter.wvs', 'li.variable-item:not(.radio-variable-item):not(.selected)', function () {
              $(this).trigger('click');
            });
          });
        }
      }
    }, {
      key: "updateCartButton",
      value: function updateCartButton(variation) {
        this.$cart_button.html(variation.add_to_cart_text);
        this.$cart_button.attr('href', variation.add_to_cart_url);
        this.$cart_button.attr('aria-label', variation.add_to_cart_description);
        this.$cart_button.addClass(variation.add_to_cart_ajax_class);
      }
    }, {
      key: "resetCartButton",
      value: function resetCartButton() {
        this.$cart_button.html(this.$cart_button.attr('data-o_html'));
        this.$cart_button.attr('href', this.$cart_button.attr('data-o_href'));
        this.$cart_button.attr('aria-label', this.$cart_button.attr('data-o_aria-label'));
        this.$cart_button.removeClass('ajax_add_to_cart');
        this.$wrapper.find('.added_to_cart').remove();
      }
    }, {
      key: "updateAvailabilityInfo",
      value: function updateAvailabilityInfo(variation) {
        if (woo_variation_swatches_pro_options.archive_show_availability) {
          var $template_html;
          var template = !variation.variation_is_visible ? wp.template('wvs-unavailable-variation-template') : wp.template('wvs-variation-template');
          $template_html = template({
            variation: variation
          });
          $template_html = $template_html.replace('/*<![CDATA[*/', '');
          $template_html = $template_html.replace('/*]]>*/', '');
          this.$information.html($template_html);
        }
      }
    }, {
      key: "resetAvailabilityInfo",
      value: function resetAvailabilityInfo() {
        this.$information.html('');
      }
    }, {
      key: "updatePrice",
      value: function updatePrice(variation) {
        if (variation && variation.price_html && variation.price_html.length > 1) {
          this.$price.html(variation.price_html);
        }
      }
    }, {
      key: "resetPrice",
      value: function resetPrice() {
        this.$price.html(this.$price_html);
      }
    }, {
      key: "defaultImage",
      value: function defaultImage() {
        this.$image.attr('data-o_src', this.$image.attr('src'));

        if (this.$image.attr('srcset')) {
          this.$image.attr('data-o_srcset', this.$image.attr('srcset'));
        }

        if (this.$image.attr('sizes')) {
          this.$image.attr('data-o_sizes', this.$image.attr('sizes'));
        }
      }
    }, {
      key: "defaultCartButton",
      value: function defaultCartButton() {
        this.$cart_button.attr('data-o_html', this.$cart_button.html());

        if (this.$cart_button.attr('href')) {
          this.$cart_button.attr('data-o_href', this.$cart_button.attr('href'));
        }

        if (this.$cart_button.attr('aria-label')) {
          this.$cart_button.attr('data-o_aria-label', this.$cart_button.attr('aria-label'));
        }
      }
    }, {
      key: "updateImage",
      value: function updateImage(variation) {
        if (variation && variation.image && variation.image.src && variation.image.src.length > 1) {
          this.$image.attr('src', variation.image.src);

          if (variation.image.srcset.length > 1) {
            this.$image.attr('srcset', variation.image.srcset);
          }

          if (variation.image.sizes.length > 1) {
            this.$image.attr('sizes', variation.image.sizes);
          }
        }
      }
    }, {
      key: "updatePreviewImage",
      value: function updatePreviewImage(variation) {
        if (variation && variation.image && variation.image.thumb_src && variation.image.thumb_src.length > 1) {
          this.$image.attr('src', variation.image.thumb_src);

          if (variation.image.srcset.length > 1) {
            this.$image.attr('srcset', variation.image.srcset);
          }

          if (variation.image.sizes.length > 1) {
            this.$image.attr('sizes', variation.image.sizes);
          }
        }
      }
    }, {
      key: "resetImage",
      value: function resetImage() {
        this.$image.attr('src', this.$image.attr('data-o_src'));

        if (this.$image.attr('data-o_srcset')) {
          this.$image.attr('srcset', this.$image.attr('data-o_srcset'));
        }

        if (this.$image.attr('data-o_sizes')) {
          this.$image.attr('sizes', this.$image.attr('data-o_sizes'));
        }
      }
    }]);

    return _class2;
  }();
}(jQuery);

var jQueryPlugin = function ($) {
  return function (PluginName, ClassName) {
    $.fn[PluginName] = function (options) {
      //return this.each((index, element) => {
      var $element = $(this);
      var data = $element.data(PluginName);

      if (!data) {
        data = new ClassName($element, $.extend({}, options));
        $element.data(PluginName, data);
      }

      if (typeof options === 'string') {
        if (_typeof(data[options]) === 'object') {
          return data[options];
        }

        if (typeof data[options] === 'function') {
          var _data;

          for (var _len = arguments.length, args = new Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
            args[_key - 1] = arguments[_key];
          }

          return (_data = data)[options].apply(_data, args);
        }
      }

      return this; //})
    }; // Constructor


    $.fn[PluginName].Constructor = ClassName; // Short hand

    $[PluginName] = function (options) {
      var _$;

      for (var _len2 = arguments.length, args = new Array(_len2 > 1 ? _len2 - 1 : 0), _key2 = 1; _key2 < _len2; _key2++) {
        args[_key2 - 1] = arguments[_key2];
      }

      return (_$ = $({}))[PluginName].apply(_$, [options].concat(args));
    }; // No Conflict


    $.fn[PluginName].noConflict = function () {
      return $.fn[PluginName];
    };
  };
}(jQuery);

jQueryPlugin('woo_variation_swatches_pro', WooVariationSwatchesPro);
jQuery(function ($) {
  // Must use each
  $('.wvs-archive-variations-wrapper').each(function () {
    $(this).woo_variation_swatches_pro();
  });
});

/***/ }),

/***/ 1:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./src/js/WooVariationSwatchesPro.js");


/***/ })

/******/ });