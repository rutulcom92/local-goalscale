(function($) {
	$(".loader").fadeIn();

	var commonScripts = function() {
		$(document).ready(function() {
			common._initialize();
			if ($('.element_select').length) {
				$('.element_select').select2();
			}

			$('body').on("change", '#chooseFile', function(e) {
				var filename = $("#chooseFile").val();
				if (/^\s*$/.test(filename)) {
					$(".file-upload").removeClass('active');
					$("#noFile").text("No file chosen...");
				} else {
					$(".file-upload").addClass('active');
					$("#noFile").text(filename.replace("C:\\fakepath\\", ""));
				}
			});

			$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
				$('div.dataTables_scrollBody').css('height', '300px');
				$.fn.dataTable.tables({
					visible: true,
					api: true
				}).draw();
				$.fn.dataTable.tables({
					visible: true,
					api: true
				}).columns.adjust().responsive.recalc();
				$.fn.dataTable.tables({
					visible: true,
					api: true
				}).scroller.measure();
			});

			// $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
			// // save the latest tab; use cookies if you like 'em better:
			//     localStorage.setItem('lastTab', $(this).attr('href'));
			// });
			// // go to the latest tab, if it exists:
			// var lastTab = localStorage.getItem('lastTab');
			// if (lastTab) {
			//     $('[href="' + lastTab + '"]').tab('show');
			// }
		});
	};
	var common = commonScripts.prototype;

	common._initialize = function() {
		common._loadSelect2();
		common._mobileInputMaskWithoutCode();
		common._zipInputMask();
		common._unmaskInput();
		common._registerEvents();
		//common._getParameterByName();
		$('#providerslisting').DataTable({
			"dom": 't'
		});;

		if ($('.datepicker-element').length) {
			common._initializeDatepicker('.datepicker-element');
		}

		if ($('.datepicker-element-no-start-date').length) {
			common._initializeDatepickerWithoutStartDate('.datepicker-element-no-start-date');
		}

		if ($('.input-daterange').length) {
			common._loadDateRangePicker('.input-daterange');
		}

		if ($('.dob-datepicker-element').length) {
			common._initializeDatepickerForDob('.dob-datepicker-element');
		}
	};

	// Generate data table
	common._generateDataTable = function(element, coloumns, orderColoumns, data, method = 'GET') {
		$('.loader').hide();
		if (orderColoumns === undefined) {
			orderColoumns = [
				[0, "desc"]
			];
		}
		table = element.DataTable({
			//dom: 'rt<"dt_footr"ip<"view_lnzk">>',
			dom: "ti",
			'paging': true,
			'searching': true,
			'ordering': true,
			'destroy': true,
			'retrieve': true,
			'info': false,
			'autoWidth': false,
			"processing": true,
			"serverSide": true,
			"bInfo": false,
			"bLengthChange": false,
			"order": orderColoumns,
			"columns": coloumns,
			scroll: true,
			scrollX: false,
			deferRender: true,
			"scroller": {
				"loadingIndicator": true
			},
			scrollY: '70vh',
			'language': {
				// sProcessing: $('.datatables-inner-loader').css('display', 'flex'),
			},
			// 'language': {
			//     paginate: {
			//         next: '<i class="fa fa-angle-right"></i>',
			//         previous: '<i class="fa fa-angle-left"></i>'
			//     },
			//     processing: '<i class="fa dt-loader-element"></i>',
			// },
			initComplete: function() {
				//
				// $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
				//     $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
				// } );
			},
			"ajax": {
				url: element.data('ajax-url'),
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type: method,
				global: false,
				"data": function(d) {
					$('.' + element.attr('id') + '-custom-filters .datatable-custom-filter').serializeArray().map(function(x) {
						if (x.name) {
							if (x.name.indexOf('[]') > 0) {
								if (!$.isArray(d[x.name])) {
									d[x.name] = new Array();
								}
								d[x.name].push(x.value);
							} else {
								d[x.name] = x.value;
							}
						}
					});
				},
				"error": function() {
					// window.location.reload();
				}
			},
			'drawCallback': function(settings, json) {
				$("[data-toggle=popover]").popover();
			},
		});


		common.table = table;
		// common._tableResetFilter();
		common._tableAddSortIcon(table);
		table.on('processing.dt', function(e, settings, processing) {
			if (processing) {
				//$('.datatables-inner-loader').css('display', 'flex');
				//element.css('opacity', 0.2);
			} else {
				$('.cm_loader').css('display', 'none');
				//$('.datatables-inner-loader').css('display', 'none');
				//element.css('opacity', 1);
			}
		});
		return table;
	};

	// $(function() {
	//     // for bootstrap 3 use 'shown.bs.tab', for bootstrap 2 use 'shown' in the next line
	//     $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	//         // save the latest tab; use cookies if you like 'em better:
	//         localStorage.setItem('lastTab', $(this).attr('href'));
	//     });
	//     // go to the latest tab, if it exists:
	//     var lastTab = localStorage.getItem('lastTab');
	//     if (lastTab) {
	//         $('[href="' + lastTab + '"]').tab('show');
	//     }
	// });

	common._tableAddSortIcon = function(table) {
		table.columns().iterator('column', function(ctx, idx) {
			if ($(table.column(idx).header()).find('.sort-icon').length == 0) {
				$(table.column(idx).header()).append('<span class="sort-icon"/>');
			}
		});
	};

	common._handleStatusToggle = function(url_, datatableObj = '', confirmMessage, thisCheck) {
		Swal.fire({
			title: '',
			text: confirmMessage,
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#4EB952', //3085d6
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes',
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url: url_,
					type: 'POST',
					dataType: 'JSON',
					data: {},
				}).done(function(data) {
					if (data.status == 'success') {
						common._toastSuccess(data.response);
					} else {
						common._toastError(data.response);
					}
					if (datatableObj != "") {
						datatableObj.ajax.reload(null, false);
					}

				});

			} else {
				if (thisCheck.prop("checked") == false) {
					thisCheck.prop('checked', true);
				} else {
					thisCheck.prop('checked', false);
				}
			}
		});
	};

	common._handleAddEditModal = function(_URL, formEle, formValidationRules, modalEle, modalContainer = '') {
		$(".loader").fadeIn();
		$.ajax({
			url: _URL,
			type: 'GET',
			dataType: 'JSON',
			async: false,
			data: {},
			beforeSend: function() {
				$(".loader").fadeIn();
			}
		}).done(function(data) {
			$(".loader").fadeOut();
			if (data.status == 'success') {
				if (modalContainer) {
					$('' + modalContainer).html(data.response);
				} else {
					$('#bsModalContent').html(data.response);
				}
				$(modalEle).modal('show');
				$(formEle).validate(formValidationRules);
				common._loadSelect2Immediately();

				if ($('.mobile-input-mask').length) {
					common._mobileInputMaskWithoutCode('.mobile-input-mask');
				}

				if ($('.zip-input-mask').length) {
					common._zipInputMask('.zip-input-mask');
				}

				if ($('.discount-input-mask').length) {
					common._discountMaskWithCode('.discount-input-mask');
				}

				if ($('.digits-input-mask').length) {
					common._digitsMaskWithCode('.digits-input-mask');
				}

				if ($('.input-daterange').length) {
					common._loadDateRangePicker('.input-daterange');
				}

				if ($('.input-daterange-no-start-date').length) {
					common._loadDateRangePickerWithoutStartDate('.input-daterange-no-start-date');
				}

				if ($('.datepicker-element').length) {
					common._initializeDatepicker('.datepicker-element');
				}

				if ($('.datepicker-element-no-start-date').length) {
					common._initializeDatepickerWithoutStartDate('.datepicker-element-no-start-date');
				}
			}
		});
	};

	common._handleAddEditModalWithoutUrl = function(formEle, formValidationRules, modalEle, modalContainer = '') {

		$(modalEle).modal('show');
		$(formEle).validate(formValidationRules);
		common._loadSelect2Immediately();

		if ($('.mobile-input-mask').length) {
			common._mobileInputMaskWithoutCode('.mobile-input-mask');
		}

		if ($('.zip-input-mask').length) {
			common._zipInputMask('.zip-input-mask');
		}

		if ($('.discount-input-mask').length) {
			common._discountMaskWithCode('.discount-input-mask');
		}

		if ($('.digits-input-mask').length) {
			common._digitsMaskWithCode('.digits-input-mask');
		}

		if ($('.input-daterange').length) {
			common._loadDateRangePicker('.input-daterange');
		}

		if ($('.input-daterange-no-start-date').length) {
			common._loadDateRangePickerWithoutStartDate('.input-daterange-no-start-date');
		}

		if ($('.datepicker-element').length) {
			common._initializeDatepicker('.datepicker-element');
		}

		if ($('.datepicker-element-no-start-date').length) {
			common._initializeDatepickerWithoutStartDate('.datepicker-element-no-start-date');
		}

	};

	common._initializeDatepickerForDob = function(input) {

		setTimeout(function() {

			if ($(input).length == 0) {
				return false;
			}

			if ($(".modal").hasClass('show')) {
				$('.modal').addClass('modal_with_datepicker');
				var container = '#' + $('.modal').attr('id');
			} else {
				$('body').addClass('modal_with_datepicker');
				var container = 'body';
			}

			$(input).datepicker({
				container: container,
				todayHighlight: true,
				autoclose: true,
				startView: 2,
				startDate: moment().subtract(200, 'years').format('MM/DD/YYYY'),
				templates: {
					leftArrow: '<img src="' + base_url + '/images/icon-arrow-left.png">',
					rightArrow: '<img src="' + base_url + '/images/icon-arrow-right.png">'
				}
			});

		}, 300);
	}

	common._loadDateRangePicker = function(input) {
		$(input).daterangepicker({
			todayHighlight: true,
			autoclose: true,
			startDate: moment().format('MM/DD/YYYY'),
			templates: {
				leftArrow: '<img src="' + base_url + '/images/icon-arrow-left.png">',
				rightArrow: '<img src="' + base_url + '/images/icon-arrow-right.png">'
			}
		});
	}

	common._loadDateRangePickerWithoutStartDate = function(input) {

		setTimeout(function() {

			if ($(input).length == 0) {
				return false;
			}

			if ($(".modal").hasClass('show')) {
				$('.modal').addClass('modal_with_datepicker');
				var container = '#' + $('.modal').attr('id');
			} else {
				$('body').addClass('modal_with_datepicker');
				var container = 'body';
			}

			$(input).datepicker({
				container: container,
				autoOpen: false,
				todayHighlight: true,
				autoclose: true,
				startDate: moment().subtract(200, 'years').format('MM/DD/YYYY'),
				templates: {
					leftArrow: '<img src="' + base_url + '/images/icon-arrow-left.pngg">',
					rightArrow: '<img src="' + base_url + '/images/icon-arrow-right.png">'
				}
			});

		}, 300);

	}

	common._initializeDatepicker = function(input) {

		setTimeout(function() {

			if ($(input).length == 0) {
				return false;
			}

			if ($(".modal").hasClass('show')) {
				$('.modal').addClass('modal_with_datepicker');
				var container = '#' + $('.modal').attr('id');
			} else {
				$('body').addClass('modal_with_datepicker');
				var container = 'body';
			}

			$(input).datepicker({
				container: container,
				todayHighlight: true,
				autoclose: true,
				startDate: moment().subtract(200, 'years').format('MM/DD/YYYY'),
				templates: {
					leftArrow: '<img src="' + base_url + '/images/icon-arrow-left.png">',
					rightArrow: '<img src="' + base_url + '/images/icon-arrow-right.png">'
				}
			});

		}, 300);
	}

	common._initializeDatepickerWithoutStartDate = function(input) {

		setTimeout(function() {

			if ($(input).length == 0) {
				return false;
			}

			if ($(".modal").hasClass('show')) {
				$('.modal').addClass('modal_with_datepicker');
				var container = '#' + $('.modal').attr('id');
			} else {
				$('body').addClass('modal_with_datepicker');
				var container = 'body';
			}

			$(input).datepicker({
				container: container,
				todayHighlight: true,
				autoclose: true,
				startDate: moment().subtract(200, 'years').format('MM/DD/YYYY'),
				templates: {
					leftArrow: '<img src="' + base_url + '/images/icon-arrow-left.png">',
					rightArrow: '<img src="' + base_url + '/images/icon-arrow-right.png">'
				}
			});

		}, 300);
	}

	common._getHtmlInputName = function(input) {
		var exploded = input.split('.');
		var inputName = '';
		if (exploded.length) {
			$.each(exploded, function(key, value) {
				if (key == 0) {
					inputName = value;
				} else {
					inputName = inputName + '[' + value + ']';
				}
			});
		} else {
			inputName = input;
		}
		return inputName;
	};

	common._showFormError = function(form, _res) {

		$(form).find('.js-error').html('');
		$(form).find('input.error').removeClass('error');

		$.each(_res, function(key, val) {
			$(form).find(':input[name="' + common._getHtmlInputName(key) + '"]').addClass('error');
			if (Array.isArray(val)) {
				$(form).find(':input[name="' + common._getHtmlInputName(key) + '"]').closest('.form-group').append('<span class="js-error">' + val.join(' ') + '</span>');
			} else {
				$(form).find(':input[name="' + common._getHtmlInputName(key) + '"]').closest('.form-group').append('<span class="js-error">' + val + '</span>');
			}
		});
	};

	common._js_ellipsis = function(str, length) {
		if (str.length > length)
			return str.substring(0, length) + '...';
		else
			return str;
	};

	common._handleDelete = function(url_, datatableObj, confirmMessage, thisCheck, skillid = '', vendorDetailId = '') {

		Swal.fire({
			title: '',
			text: confirmMessage,
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#4EB952', //#3085d6
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes',
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url: url_,
					type: 'POST',
					dataType: 'JSON',
					data: {
						_method: 'DELETE'
					},
				}).done(function(data) {
					if (data.status == 'success') {
						common._toastSuccess(data.response);
					} else {
						common._toastError(data.response);
					}
					if (datatableObj != "") {
						datatableObj.ajax.reload(null, false);
					}
					if (skillid != "") {
						$('#skill_' + skillid).remove();
					}
					if (vendorDetailId != "") {
						$('.id' + vendorDetailId).remove();
					}

				});

			} else {
				if (thisCheck.prop("checked") == false) {
					thisCheck.prop('checked', true);
				} else {
					thisCheck.prop('checked', false);
				}
			}
		});
	};

	common._loadSelect2 = function() {
		setTimeout(function() {
			if ($('.select2-element').length > 0) {
				$('.select2-element').each(function() {
					$(this).select2({
						dropdownParent: $(this).parent()
					});
				});
			}
		}, 400);

		setTimeout(function() {
			if ($('.select2-no-search').length > 0) {
				$('.select2-no-search').each(function() {
					$(this).select2({
						dropdownParent: $(this).parent(),
						minimumResultsForSearch: -1
					});
				});
			}
		}, 400);

		setTimeout(function() {
			if ($('.multi_select_element').length > 0) {
				$('.multi_select_element').each(function() {
					$(this).select2({
						tags: true,
						tokenSeparators: [',', ' '],
						placeholder: function() {
							$(this).data('placeholder');
						},
						createTag: function(params) {
							return undefined;
						}
					});
				});
			}
		}, 400);
	};

	common._loadSelect2Immediately = function() {
		if ($('.select2-element').length > 0) {
			$('.select2-element').each(function() {
				$(this).select2({
					dropdownParent: $(this).parent()
				});
			});
		}

		if ($('.select2-no-search').length > 0) {
			$('.select2-no-search').each(function() {
				$(this).select2({
					dropdownParent: $(this).parent(),
					minimumResultsForSearch: -1
				});
			});
		}
	};

	common._searchDT = function(dtId, searchString) {
		if ($('#' + dtId).length > 0) {
			$('#' + dtId).DataTable().search(searchString).draw();
		}
	};

	common._reloadDTAjax = function(dtId) {
		if ($('#' + dtId).length > 0) {
			$('#' + dtId).DataTable().ajax.reload();
		}
	};

	common._mobileInputMaskWithoutCode = function(elem) {

		if ($(elem).length > 0) {

			$(elem).inputmask("(999) 999-9999", {
				// "clearIncomplete": true,
				"removeMaskOnSubmit": true
			});
		}
	};

	common._getParameterByName = function(name, url) {

		if (!url) url = window.location.href;
		name = name.replace(/[\[\]]/g, '\\$&');
		var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
			results = regex.exec(url);
		if (!results) return null;
		if (!results[2]) return '';
		return decodeURIComponent(results[2].replace(/\+/g, ' '));
	};

	common._discountMaskWithCode = function(elem) {

		if ($(elem).length > 0) {
			$(elem).inputmask({
				'alias': 'numeric',
				'autoGroup': true,
				'allowPlus': false,
				'allowMinus': false,
				'integerDigits': 12,
				'unmaskAsNumber': true,
				'digits': 2,
			});
		}
	};

	common._digitsMaskWithCode = function(elem) {

		if ($(elem).length > 0) {
			$(elem).inputmask({
				'alias': 'numeric',
				'autoGroup': true,
				'allowPlus': false,
				'allowMinus': false,
				'integerDigits': 12,
				'unmaskAsNumber': true,
				'digits': 0,
			});
		}
	};

	common._zipInputMask = function(elem) {

		if ($(elem).length > 0) {
			$(elem).inputmask("99999", {
				//"clearIncomplete": true,
				"removeMaskOnSubmit": true
			});
		}
	};

	common._unmaskInput = function(elem) {

		if ($(elem).length > 0) {
			$(elem).inputmask('remove');
		}
	};

	common._toastSuccess = function(msg) {

		iziToast.success({
			backgroundColor: '#34920d',
			messageColor: '#fff',
			titleColor: '#fff',
			icon: 'fa fa-check',
			iconColor: '#fff',
			transitionIn: 'bounceInRight',
			title: 'Success!',
			message: "" + msg
		});
	};

	common._toastError = function(msg) {

		iziToast.error({
			backgroundColor: '#BC5459',
			messageColor: '#fff',
			titleColor: '#fff',
			icon: 'fa fa-ban',
			iconColor: '#fff',
			transitionIn: 'bounceInRight',
			title: 'Error!',
			message: "" + msg
		});
	};

	common._isEmpty = function(el) {
		return !$.trim(el.html())
	};

	common._loadCollorPicker = function() {
		if ($('.colorpicker-component').length > 0) {
			$('.colorpicker-component').each(function() {
				$(this).colorpicker();
			});
		}
	};

	common._registerEvents = function() {

		$('body').on('click', '.popfirst', function(e) {
			$('.PopOver_cool').slideDown();
		});
		$('body').on('click', '.cl_cool_close', function(e) {
			$('.PopOver_cool').slideUp();
		});

		$('body').on('click', '#closed', function(e) {
			window.history.back();
		});

		$('body').on('click', '#closed1', function(e) {
			if ($('#back_url').val() != '') {
				setTimeout(function() {
					window.location.href = $('#back_url').val();
				}, 1000);
			}
		});

		$('body').on('click', '.popsecond', function(e) {
			$('.PopOver_cool_manager').slideDown();
			$('.PopOver_cool_property_contact').slideUp();
		});
		$('body').on('click', '.cl_cool_close', function(e) {
			$('.PopOver_cool_manager').slideUp();
		});

		$('body').on('click', '.poppropertycontact', function(e) {
			$('.PopOver_cool_property_contact').slideDown();
			$('.PopOver_cool_manager').slideUp();
		});
		$('body').on('click', '.cl_cool_property_contact_close', function(e) {
			$('.PopOver_cool_property_contact').slideUp();
		});

		$('body').on('click', '.popregionalmanager', function(e) {
			$('.PopOver_cool_regional_manager').slideDown();
			$('.PopOver_cool_other_company_contact').slideUp();
		});
		$('body').on('click', '.cl_cool_regional_manager_close', function(e) {
			$('.PopOver_cool_regional_manager').slideUp();
		});

		$('body').on('click', '.popothercompanycontact', function(e) {
			$('.PopOver_cool_other_company_contact').slideDown();
			$('.PopOver_cool_regional_manager').slideUp();
		});
		$('body').on('click', '.cl_cool_other_company_contact_close', function(e) {
			$('.PopOver_cool_other_company_contact').slideUp();
		});

		$('body').on('click', '.next-step, .prev-step', function(e) {

			$('#memberAudioError').html('');

			if ($(".modal-body").length == 0) {
				var tabs = $(this).closest("form").find(".tabs-process-validate").tabs();
			} else {
				var tabs = $(this).closest("form").find(".modal-body").tabs();
			}
			var formid = $(this).closest("form").attr("id");
			var validator = $("#" + formid).validate();
			var $activeTab = $(this).closest("form").find('.tab-pane.active');
			if ($(e.target).hasClass('next-step')) {

				var valid = true;
				var i = 0;
				var $inputs = $activeTab.find("input, select, textarea");

				$inputs.each(function() {
					if (!validator.element(this) && valid) {
						// $(this).focus();
						valid = false;
					}
				});

				if (valid) {

					if ($('#memberStatusId').length > 0 && $('.tab-pane.active').attr('id') == "menu4") {
						if (memberAudioSelected == 0 && ($('#memberStatusId').val() == 1 || $("#memberStatusId option:selected").text() == "Active")) {
							$('#memberAudioError').html('Please upload member audio.');
							return false;
						}
					}

					$('.btn-circle.btn-info').removeClass('btn-info').addClass('btn-default');

					var nextHeaderTabId = $(this).closest("form").find('.nav-link.active').parent().next('li').attr('id');

					$(this).closest("form").find('.nav-tabs .nav-link.active').removeClass('active');

					$('#' + nextHeaderTabId + ' a').addClass('active');

					var nextTab = $activeTab.next('.tab-pane').attr('id');
					if (nextTab != null) {
						$('.' + nextTab).addClass('btn-info').removeClass('btn-default');
						$('.' + nextTab).tab('show');

						$("#" + nextTab).addClass('active show');
						$(this).closest("form").find(".tab-pane").not("#" + nextTab).removeClass('active show').blur();

						if (nextTab == "menu1") {
							$('.prev-step').hide();
						} else {
							$('.prev-step').show();
						}

						var nextTab = $(this).closest("form").find('.tab-pane.active').next('.tab-pane').attr('id');

						if (nextTab == null) {
							$('.next-step').hide();
							$('.save-client').show();
						} else {
							$('.next-step').show();
							$('.save-client').hide();
						}
					} else {

						$('.next-step').hide();
						$('.save-client').show();
					}
				} else {
					return;
				}


			} else {
				var prevTab = $activeTab.prev('.tab-pane').attr('id');
				$('.btn-circle.btn-info').removeClass('btn-info').addClass('btn-default');
				$('.' + prevTab).addClass('btn-info').removeClass('btn-default');
				$('.' + prevTab).tab('show');

				$("#" + prevTab).addClass('active show');
				$(this).closest("form").find(".tab-pane").not("#" + prevTab).removeClass('active show').blur();
				$('.next-step').show();
				$('.save-client').hide();
				if (prevTab == "menu1") {
					$('.prev-step').hide();
				} else {
					$('.prev-step').show();
				}
			}
		});

		// $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
		//     $.fn.dataTable.tables({
		//         visible: true,
		//         api: true
		//     }).columns.adjust();
		// });

		$('[data-toggle="tooltip"]').tooltip();
		$('[data-toggle="popover"]').popover();

		$(".loader").fadeOut();

		/*
		Trim each text field before jQuery validation
		*/
		if ($.validator != undefined && $.validator.methods.length) {
			$.each($.validator.methods, function(key, value) {
				$.validator.methods[key] = function() {
					if (arguments.length > 0) {
						arguments[0] = $.trim(arguments[0]);
					}

					return value.apply(this, arguments);
				};
			});
		}

		$(document).on('keyup', '.datatable-common-search-input', function() {
			common._searchDT($(this).data('table-id'), $(this).val());
		});

		$(document).on('change', '.datatable-custom-filter', function() {
			common._reloadDTAjax($(this).data('table-id'));
		});

		$(document).on('click', '.nav-item', function() {
			common._reloadDTAjax($(this).data('table-id'));
		});

		$(document).on('change', '.datatable-common-inactive-filter', function() {
			common._reloadDTAjax($(this).data('table-id'));
		});

		$(document).on('click', '.tbl_toogle', function() {

			$(this).toggleClass('active');
			$(this).closest('.dropdown_cover').find(".drop_down").slideToggle();

			$('.drop_down').not('*[data-dd-id="' + $(this).closest('.dropdown_cover').find(".drop_down").attr('data-dd-id') + '"]').slideUp();

		});

		$(document).on("change", '.select2-element', function(e) {
			var $tSel = $(this);
			if ($tSel.val() !== '') {
				$tSel.next('span').next('label.error').hide();
			}
		});

		$(document).click(function(event) {
			if (!$(event.target).hasClass('dropdown_cover') && !$(event.target).hasClass('tbl_toogle') && event.target.nodeName != "IMG") {
				$('.drop_down').slideUp();
			}
		});

		$(document).on("change", '.error', function(e) {
			$(this).valid();
		});

		$(document).on('click', '.preview-ckeditor', function() {
			common._previewCkeditor($(this).data('id'));
		});

		$(document).on('hidden.bs.modal', function(event) {
			if ($('.modal:visible').length) {
				$('body').addClass('modal-open');
			}
		});

		$('.web-logo-change').click(function() {
			$('#user-logo').click();
		});
		$('#user-logo').change(function(e) {
			$(".loader").fadeIn();
			var reader = new FileReader();
			reader.onload = function() {
				var output = document.getElementById('user-logo-image');
				$('.upload_logo_UI a span').remove();
				$('.upload_logo_UI a img').css("width", '99%');
				$('.upload_logo_UI a img').css("height", '97%');
				$('.upload_logo_UI a img').css("filter", 'none');
				$('.upload_logo_UI a img').css("object-fit", 'cover');

				output.src = reader.result;
				var formData = new FormData();
				formData.append('logo_image', $("#user-logo")[0].files[0]);
				$.ajax({
					url: $('#userForm').attr('action'),
					data: formData,
					dataType: 'json',
					async: false,
					type: 'POST',
					processData: false,
					contentType: false,
				}).done(function(data) {
					if (data.status == 'success') {
						$(".loader").fadeOut();
						$('#userForm').trigger("reset");
						common._toastSuccess(data.response);
					}
				});
			}
			reader.readAsDataURL(e.target.files[0]);
		});
	};

	common._validFileExtensions = function(input, extensions) {
		if (input.type == "file") {
			var sFileName = input.value;
			if (sFileName.length > 0) {
				var blnValid = false;
				for (var j = 0; j < extensions.length; j++) {
					var sCurExtension = extensions[j];
					if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
						return true;
					}
				}
				if (!blnValid) {
					return false;
				}
			}
		}
		return false;
	};

	common._loadCKeditors = function() {
		$('textarea.editor').each(function() {

			var instance = CKEDITOR.instances[$(this).attr('id')];

			if (!instance) {
				var editor = CKEDITOR.replace($(this).attr('id'), {
					height: '200px',
				});
				editor.on('change', function() {
					$('#' + editor.name).text(editor.getData());
				});
			}
		});
	};

	common._previewCkeditor = function(id) {

		var contents = CKEDITOR.instances[id].getData();

		$.ajax({
			url: base_url + '/loadCkEditorPreview',
			type: 'POST',
			dataType: 'JSON',
			data: {
				content: contents
			},
			beforeSend: function() {
				$(".loader").fadeIn();
			}
		}).done(function(data) {
			$(".loader").fadeOut();
			if (data.status == 'success') {
				var w = window.open('about:blank');
				w.document.open();
				w.document.write(data.response);
				w.document.close();
			}
		});
	};

	window.commonScripts = new commonScripts();
})(jQuery);
