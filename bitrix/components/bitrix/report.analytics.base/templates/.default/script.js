(function ()
{
	BX.namespace("BX.Report.Analytics");

	BX.Report.Analytics.Page = function (options)
	{
		this.scope = options.scope;
		this.menuScope = options.menuScope;
		// this.menuItemsContainers = this.menuScope.querySelectorAll('[data-role="report-analytics-menu-items-container"]');
		this.changeBoardButtons = this.menuScope.querySelectorAll('[data-role="report-analytics-menu-item"]');
		this.contentContainer = this.scope.querySelector('.report-analytics-content');
		this.currentItem = this.menuScope.querySelector('.report-analytics-sidebar-submenu-item.report-analytics-sidebar-submenu-item-active');
		this.currentSelectedContainer = this.menuScope.querySelector('.report-analytics-sidebar-menu-item.report-analytics-sidebar-menu-item-active');
		this.pageTitle = document.getElementById('pagetitle');
		this.pageTitleWrap = document.querySelector('.pagetitle-wrap');
		this.pageControlsContainer = document.querySelector('.pagetitle-container.pagetitle-align-right-container');

		this.defaultBoardKey = options.defaultBoardKey;

		this.init();
	};

	BX.Report.Analytics.Page.prototype = {
		init: function ()
		{
			// this.menuItemsContainers.forEach(function(button) {
			// 	BX.bind(button, 'click', this.handleContainerClick.bind(this));
			// }.bind(this));
			this.changeBoardButtons.forEach(function(button) {
				BX.bind(button, 'click', this.handleItemClick.bind(this));
			}.bind(this));
			this.loader = new BX.Loader({size: 80});
			top.onpopstate = this.handlerOnPopState.bind(this);
		},
		handleContainerClick: function(event)
		{
			var container = event.currentTarget;

			var activeClassName = "report-analytics-sidebar-menu-item-active";
			var activeItemInThisContainer = container.querySelector('.report-analytics-sidebar-submenu-item-active');
			if (!activeItemInThisContainer && container.classList.contains("report-analytics-sidebar-menu-item-active"))
			{
				var submenuContainer = container.querySelector('.report-analytics-sidebar-submenu');
				submenuContainer.style.height = 0;
				container.classList.remove(activeClassName);
			}
			else
			{
				this.currentSelectedContainer = container;
				this.currentSelectedContainer.classList.add(activeClassName);
				var submenuContainer = this.currentSelectedContainer.querySelector('.report-analytics-sidebar-submenu');
				var menuItemCount = submenuContainer.querySelectorAll('[data-role="report-analytics-menu-item"]').length;
				submenuContainer.style.height = ((36 * menuItemCount) + (menuItemCount * 6) - 6)  + 'px';
			}
		},
		handleItemClick: function(event)
		{
			event.preventDefault();
			var button = event.currentTarget;


			this.activateButton(event);
			var boardKey = button.dataset.reportBoardKey;
			this.cleanPageContent();
			this.showLoader();
			BX.Report.VC.Core.ajaxPost('analytics.getBoardComponentByKey', {
				data: {
					IFRAME: 'Y',
					boardKey: boardKey
				},
				onFullSuccess: function(result)
				{
					this.hideLoader();
					var isDisabled = button.dataset.disabledBoard;

					top.history.pushState(null, result.additionalParams.pageTitle, button.href);
					top.history.replaceState({
						reportBoardKey: boardKey,
						href: button.href
					}, result.additionalParams.pageTitle, button.href);

					this.changePageTitle(result.additionalParams.pageTitle);
					this.changePageControls(result.additionalParams.pageControlsParams);

					BX.html(this.contentContainer, result.data);
				}.bind(this)
			})
		},
		cleanPageContent: function ()
		{
			this.pageTitle.innerText = '';
			this.pageControlsContainer.innerText = '';
			BX.cleanNode(this.contentContainer);
			if (BX.Report.Dashboard)
			{
				BX.Report.Dashboard.BoardRepository.destroyBoards();
			}

		},
		changePageControls: function(controlsContent)
		{
			var config = {};
			config.onFullSuccess = function(result) {
				BX.html(this.pageControlsContainer, result.html);
			}.bind(this);
			BX.Report.VC.Core._successHandler(controlsContent, config);
		},

		changePageTitle: function(title)
		{
			this.pageTitle.innerText = title;
		},
		showLoader: function()
		{
			this.pageTitleWrap.style.display = 'none';

			var preview = BX.create('img', {
				attrs: {
					'src': '/bitrix/images/report/visualconstructor/preview/view-without-menu.svg',
					height: '1200px',
					width: '100%'
				}
			});
			this.contentContainer.appendChild(preview);
		},
		hideLoader: function()
		{
			this.pageTitleWrap.style.display = 'block';
			this.loader.hide();
		},
		activateButton: function(event)
		{
			var item = event.currentTarget;

			if (!this.currentItem)
			{
				this.currentItem = item;
			}

			this.currentItem.classList.remove("report-analytics-sidebar-submenu-item-active");
			this.currentItem = item;
			this.currentItem.classList.add("report-analytics-sidebar-submenu-item-active");
		},
		handlerOnPopState: function(event) {
			var boardKey = this.defaultBoardKey;
			if (event.state.reportBoardKey !== undefined)
			{
				boardKey = event.state.reportBoardKey;
			}

			this.cleanPageContent();
			this.showLoader();
			BX.Report.VC.Core.ajaxPost('analytics.getBoardComponentByKey', {
				data: {
					IFRAME: 'Y',
					boardKey: boardKey
				},
				onFullSuccess: function(result)
				{
					this.hideLoader();
					this.cleanPageContent();
					this.changePageTitle(result.additionalParams.pageTitle);
					this.changePageControls(result.additionalParams.pageControlsParams);
					BX.html(this.contentContainer, result.data);
				}.bind(this)
			});
		}

	}
})();
