<?php
$demo_site = array(
	'main' => array(
		'name'  => esc_html__('Main','beyot-framework'),
		'path'  => 'beyot',
		'link'  => 'http://themes.g5plus.net/beyot/'
	),
	'single-property' => array(
		'name'  => esc_html__('Single Property Langding','beyot-framework'),
		'path'  => 'beyot-single-property',
		'link'  => 'http://themes.g5plus.net/beyot-single-property/'
	),
	'single-agent' => array(
		'name'  => esc_html__('Single Agent Demo','beyot-framework'),
		'path'  => 'beyot-single-agent',
		'link'  => 'http://themes.g5plus.net/beyot-single-agent/'
	),
	'idxpress' => array(
		'name'  => esc_html__('IDXpress','beyot-framework'),
		'path'  => 'beyot-idx',
		'link'  => 'http://themes.g5plus.net/beyot-idx/'
	),
	'ihome' => array(
		'name'  => esc_html__('iHomeFinder','beyot-framework'),
		'path'  => 'beyot-ihome',
		'link'  => 'http://themes.g5plus.net/beyot-ihome/'
	),
);
foreach ($demo_site as $key => $value) {
	$demo_site[$key]['image'] = GF_PLUGIN_URL . 'core/install-demo/data/' . $key . '/preview.jpg';
}

$hide_fix_class = 'hide';
if (isset($_REQUEST['fix-demo-data']) && ($_REQUEST['fix-demo-data'] == '1')) {
$hide_fix_class = '';
}
?>
<div class="g5plus-demo-data-wrapper">
	<h1><?php esc_html_e('G5PLUS - Install Demo Data','beyot-framework') ?></h1>
	<p><?php esc_html_e('Please choose demo to install (take about 3-35 mins)','beyot-framework') ?></p>
	<ul>
		<li><?php echo sprintf(__('<strong>1. Main demo and Single Agent Demo:</strong> Please active all plugin require (not idxpress, ihomefinder)', 'beyot-framework')); ?></li>
		<li><?php echo sprintf(__('<strong>2. Single Property Landing demo:</strong> Please active all plugin require (not Essential Real Estate plugin, idxpress, ihomefinder)', 'beyot-framework')); ?></li>
		<li><?php echo sprintf(__('<strong>3. IDXpress demo:</strong> Please active all plugin require (not Essential Real Estate plugin) and active IDXpress plugin', 'beyot-framework')); ?></li>
		<li><?php echo sprintf(__('<strong>4. iHomeFinder demo:</strong> Please active all plugin require (not Essential Real Estate plugin) and active ihomefinder plugin', 'beyot-framework')); ?></li>
	</ul>
	<div class="install-message" data-success="<?php esc_html_e('Install Done','beyot-framework') ?>"></div>
	<div class="g5plus-demo-site-wrapper">
		<div class="demo-site-row">
			<?php foreach ($demo_site as $key => $value): ?>
				<div class="demo-site-col">
					<div class="g5plus-demo-site">
						<div class="g5plus-demo-site-inner">
							<div class="demo-site-thumbnail">
								<div class="centered">
									<img src="<?php echo esc_url($value['image'])?>" alt="<?php echo esc_attr($value['name'])?>"/>
								</div>
							</div>
							<a href="<?php echo esc_url($value['link']); ?>" target="_blank" class="link-demo"><?php esc_html_e('Preview','beyot-framework'); ?></a>
							<div class="progress-bar meter">
								<span style="width: 0%"></span>
							</div>
						</div>
						<h3>
							<span><?php echo esc_html($value['name'])?></span>
							<?php if (isset($_REQUEST['fixdemo'])): ?>
								<button class="fix-button"><?php esc_html_e('Fix Demo Data','beyot-framework') ; ?></button>
							<?php else: ?>
								<button id="install_demo" class="install-button" data-demo="<?php echo esc_attr($key) ?>" data-path="<?php echo esc_attr($value['path']) ?>"><i class="fa fa-spin fa-spinner"></i><?php esc_html_e('Install','beyot-framework'); ?></button>
								<button id="install_setting" class="install-button" data-demo="<?php echo esc_attr($key) ?>" data-path="<?php echo esc_attr($value['path']) ?>"><i class="fa fa-spin fa-spinner"></i><?php esc_html_e('Only Setting','beyot-framework'); ?></button>
							<?php endif;?>
						</h3>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>