/**
 * Smooth Image Transition effect
 *
 * @author Stefan Galinski <sgalinski@df.eu>
 */
var dfTabsSmoothImageTransition = {
	/**
	 * Preparation for the animation effects
	 *
	 * @param {TabBar} tabBar
	 * @return {void}
	 */
	beforeInitialize: function(tabBar) {
		tabBar.elementMap.each(function(element) {
			element.contentItem.set('tween', {
				duration: tabBar.options.animationSpeed
			});

			if (!element.contentItem.hasClass(tabBar.options.classPrefix + 'tabContentSelected')) {
				element.contentItem.fade('hide');
			}
		});
	},

	/**
	 * Animates the transition between two tabs
	 *
	 * @param {int} nextTabIndex
	 * @return {void}
	 */
	tabChange: function(nextTabIndex) {
		if (this.previousTab < 0) {
			return;
		}

		this.elementMap[this.previousTab].contentItem.fade('out');
		this.elementMap[nextTabIndex].contentItem.fade('in');

		var selectedClass = this.options.classPrefix + 'tabMenuEntrySelected';
		this.elementMap.each(function(element) {
			element.menuItem.removeClass(selectedClass);
		});
		this.elementMap[nextTabIndex].menuItem.addClass(selectedClass);
		this.previousTab = nextTabIndex;
	}
};