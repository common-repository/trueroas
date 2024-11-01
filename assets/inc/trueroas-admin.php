<?php
class TrueRoas_Admin {
  public function __construct() {
    add_action('admin_menu', array($this, 'add_menu_page'));
  }
  

  public function add_menu_page() {
    add_menu_page(
      'TrueRoas',
      'TrueRoas',
      'manage_options',
      'trueroas',
      array($this, 'render_page'),
      'dashicons-chart-pie'
    );
  }

  public function render_page() {
    ?>
    <div class="trueroas-container">
      <img src="<?php echo TRUEROAS_CORE_IMG.'logo.webp'; ?>" />
      <h1 style="text-align: center"><?php _e('Wohoo! You\'re all set up🎉','trueroas')?></h1>
      <p style="text-align: center"><?php _e('Next step is to make sure that all your ads are tracking <a style="color: #303fe1"  target="_blank" href="https://app.trueroas.io/utm">here</a>','trueroas')?>.</p>
      <a class="trueroas-button" target="_blank" href="https://app.trueroas.io"><?php _e('Go to your TrueROAS Account','trueroas');?></a>
    </div>
    <style>
      .trueroas-container {
        max-width: 800px;
        margin: 0 auto;
        text-align: center;
        padding: 50px 0;
      }
      .trueroas-button {
        display: inline-block;
        background-color: #303fe1;
        color: white;
        padding: 15px 30px;
        border-radius: 5px;
        margin-top: 20px;
        text-decoration: none;
      }
       .trueroas-button:hover {
        display: inline-block;
        color: white;
        background-color: #14195c;
      }
    </style>
    <?php
  }
}

$trueroas_admin = new TrueRoas_Admin();
