BitrixSUG = function ()
{

};

BitrixSUG.prototype.sendRequest = function(params)
{
	if (
		typeof params == 'undefined'
		|| typeof params.groupId == 'undefined'
		|| parseInt(params.groupId) <= 0
	)
	{
		return false;
	}

	this.showWait(params.button);

	BX.ajax({
		url: '/bitrix/components/bitrix/socialnetwork.user_groups/ajax.php',
		method: 'POST',
		dataType: 'json',
		data: {
			sessid : BX.bitrix_sessid(),
			site : BX.message('SITE_ID'),
			groupId: parseInt(params.groupId),
			action : 'REQUEST'
		},
		onsuccess: BX.proxy(function(responseData) {
			this.closeWait(params.button);
			if (typeof responseData.SUCCESS != 'undefined')
			{
				BX.cleanNode(params.button, true);
			}
			else
			{
				if (typeof responseData.ERROR != 'undefined')
				{
					this.showError(responseData.ERROR);
				}
			}
		}, this),
		onfailure: BX.proxy(function(responseData) {
			this.showError(BX('SONET_C33_T_F_REQUEST_ERROR'));
		}, this)
	});

	return false;
};

BitrixSUG.prototype.showWait = function(target)
{
	BX.addClass(target, 'webform-small-button-wait');
};

BitrixSUG.prototype.closeWait = function(target)
{
	BX.removeClass(target, 'webform-small-button-wait');
};

BitrixSUG.prototype.showError = function(errorText)
{
	this.closeWait();
	var errorPopup = new BX.PopupWindow('ug-error' + Math.random(), window, {
		autoHide: true,
		lightShadow: false,
		zIndex: 2,
		content: BX.create('DIV', {props: {'className': 'sonet-groups-error-text-block'}, html: BX.message('SONET_C33_T_F_REQUEST_ERROR').replace('#ERROR#', errorText)}),
		closeByEsc: true,
		closeIcon: true
	});
	errorPopup.show();
};

BitrixSUG.prototype.showSortMenu = function(params)
{
	BX.PopupMenu.destroy('bx-sonet-groups-sort-menu');
	BX.PopupMenu.show('bx-sonet-groups-sort-menu', params.bindNode, [
		{
			text: BX.message('SONET_C33_T_F_SORT_ALPHA'),
			onclick: BX.proxy(function() {
				this.selectSortMenuItem({
					text: BX.message('SONET_C33_T_F_SORT_ALPHA'),
					key: 'alpha',
					valueNode: params.valueNode
				});
				BX.PopupMenu.destroy('bx-sonet-groups-sort-menu');
			}, this)
		},
		{
			text: BX.message('SONET_C33_T_F_SORT_DATE_REQUEST'),
			onclick: BX.proxy(function() {
				this.selectSortMenuItem({
					text: BX.message('SONET_C33_T_F_SORT_DATE_REQUEST'),
					key: 'date_request',
					valueNode: params.valueNode
				});
				BX.PopupMenu.destroy('bx-sonet-groups-sort-menu');
			}, this)
		},
		(
			parseInt(params.userId) == BX.message('USER_ID')
				? {
					text: BX.message('SONET_C33_T_F_SORT_DATE_VIEW'),
					onclick: BX.proxy(function() {
						this.selectSortMenuItem({
							text: BX.message('SONET_C33_T_F_SORT_DATE_VIEW'),
							key: 'date_view',
							valueNode: params.valueNode
						});
						BX.PopupMenu.destroy('bx-sonet-groups-sort-menu');
					}, this)
				}
				: null
		),
		(
			params.showMembersCountItem
				? {
					text: BX.message('SONET_C33_T_F_SORT_MEMBERS_COUNT'),
					onclick: BX.proxy(function() {
						this.selectSortMenuItem({
							text: BX.message('SONET_C33_T_F_SORT_MEMBERS_COUNT'),
							key: 'members_count',
							valueNode: params.valueNode
						});
						BX.PopupMenu.destroy('bx-sonet-groups-sort-menu');
					}, this)
				}
				: null
		),
		{
			text: BX.message('SONET_C33_T_F_SORT_DATE_ACTIVITY'),
			onclick: BX.proxy(function() {
				this.selectSortMenuItem({
					text: BX.message('SONET_C33_T_F_SORT_DATE_ACTIVITY'),
					key: 'date_activity',
					valueNode: params.valueNode
				});
				BX.PopupMenu.destroy('bx-sonet-groups-sort-menu');
			}, this)
		}
	], {
		offsetLeft: 110,
		offsetTop: -15,
		lightShadow: false,
		angle: {position: 'top', offset : 50}
 	});

	return false;
};

BitrixSUG.prototype.selectSortMenuItem = function(params)
{
	BX(params.valueNode).innerHTML = params.text;
	var url = null;

	switch(params.key)
	{
		case 'alpha':
			url = BX.message('filterAlphaUrl');
			break;
		case 'date_request':
			url = BX.message('filterDateRequestUrl');
			break;
		case 'date_view':
			url = BX.message('filterDateViewUrl');
			break;
		case 'members_count':
			url = BX.message('filterMembersCountUrl');
			break;
		case 'date_activity':
			url = BX.message('filterDateActivitytUrl');
			break;
		default:
			url = BX.message('filterAlphaUrl')
	}

	document.location.href = url;
};


oSUG = new BitrixSUG;
window.oSUG = oSUG;