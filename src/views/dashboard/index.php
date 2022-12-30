<?= self::html() ?>

<?= self::body() ?>

<?//Global javascript keep it on top?>
<script src="<?=asset('js/dashboard/global.js')?>"></script>

<div class="centerd-column padd gap0">
  <div class="flex-grid top1 padd1">
    <div id='configurationContainer' class="st-highlight padd shadow"><?php require_once "configuration.php"; ?></div>
    <div id='productsSelectorContainer' class="st-highlight padd shadow minhalf undisplay"><?php require_once "productViewer.php"; ?></div>
    <div id='partnersSelectorContainer' class="st-highlight padd shadow undisplay"><?php require_once "businessPartner.php"; ?></div>
    <div id='paymentsSelectorContainer' class="st-highlight padd shadow undisplay"><?php require_once "paymentsmethods.php"; ?></div>
  </div>
  <div class="top1 padd st-highlight padd shadow"><?php require_once "board.php"; ?></div>
</div>

<script src="<?= asset('js/dashboard/functions.js')?>"></script>
<script src="<?= asset('js/dashboard/loadandlisteners.js')?>"></script>
<?= self::end() ?>