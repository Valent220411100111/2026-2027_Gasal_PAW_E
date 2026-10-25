<?php
// tampilkan kembali isian sebelumnya (password sengaja tidak diisi ulang)
function old($name)
{
    return isset($_POST[$name]) ? htmlspecialchars($_POST[$name], ENT_QUOTES) : '';
}
$selState = isset($_POST['state']) ? $_POST['state'] : '-1';
$selSex   = isset($_POST['sex']) ? $_POST['sex'] : '';
// tampilkan pesan error milik satu field (jika ada)
function showErr($name)
{
    global $errors;
    if (isset($errors[$name]))
        echo '<span class="err">' . htmlspecialchars($errors[$name]) . '</span>';
}
$states = array('1' => 'Australian Capital Territory', '2' => 'Queensland',
    '3' => 'Victoria', '4' => 'New South Wales', '5' => 'Tasmania',
    '6' => 'South Australia', '7' => 'Western Australia', '8' => 'Northern Territory');
?>
<fieldset>
<legend>Person Details</legend>
<form name="myForm" action="processData_form.php" method="POST">
  <div class="field">
    <label for="surname">Surname</label>
    <input type="text" name="surname" size="31" value="<?php echo old('surname'); ?>"/><?php showErr('surname'); ?>
  </div>
  <div class="field">
    <label for="email">Email address</label>
    <input type="text" name="email" size="31" value="<?php echo old('email'); ?>"/><?php showErr('email'); ?>
  </div>
  <div class="field">
    <label for="passwd">Password</label>
    <input type="password" name="passwd" size="31"/><?php showErr('passwd'); ?>
  </div>
  <div class="field">
    <label for="address">Street Address</label>
    <textarea name="address" rows="3" cols="22"><?php echo old('address'); ?></textarea><?php showErr('address'); ?>
  </div>
  <div class="field">
    <label for="state">State</label>
    <select name="state">
      <option value="-1" <?php if ($selState === '-1') echo 'selected'; ?>>[choose your state]</option>
      <?php foreach ($states as $val => $label) { ?>
      <option value="<?php echo $val; ?>" <?php if ($selState === (string)$val) echo 'selected'; ?>><?php echo $label; ?></option>
      <?php } ?>
    </select><?php showErr('state'); ?>
  </div>
  <div class="field">
    <input type="hidden" name="country" value="Australia">
  </div>
  <div class="field">
    <label for="sex">Gender</label>
    <span><input type="radio" name="sex" value="male" <?php if ($selSex === 'male') echo 'checked'; ?>/>Male
    <input type="radio" name="sex" value="female" <?php if ($selSex === 'female') echo 'checked'; ?>/>Female</span><?php showErr('sex'); ?>
  </div>
  <div class="field">
    <label for="vegetarian">Vegetarian?</label>
    <input type="checkbox" name="vegetarian" <?php if (isset($_POST['vegetarian'])) echo 'checked'; ?>/>
  </div>
  <div class="field">
    <label>&nbsp;</label>
    <span><input type="submit" value="Submit" name="submit" /><input type="reset" value="Reset" name="reset" /></span>
  </div>
</form>
</fieldset>
