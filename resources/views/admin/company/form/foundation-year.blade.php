<? //<editor-fold desc="Год основания">?>
<div class="form-group">
  <label class="form-control-label"><?=__('Год основания')?></label>
  <input type="number" max="<?=date('Y')?>" class="form-control input-sm" name="foundation_year" value="<? if ((int)$company->foundation_year) echo $company->foundation_year ?>" placeholder="xxxx">
</div>
<? //</editor-fold>?>