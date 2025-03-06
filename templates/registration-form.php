<form method="post" action="">
    <label>Business Name (Shop Name) *</label>
    <input type="text" name="business_name" placeholder="Enter your business name" required>

    <label>Owner Name</label>
    <input type="text" name="owner_name" placeholder="Enter owner's name">

    <label>Country/Region *</label>
    <select name="country" required>
        <option value="" disabled selected>Select your country</option>
        <?php
        $allowed_countries = WC()->countries->get_allowed_countries();
        foreach ($allowed_countries as $country_code => $country_name) {
            echo "<option value='$country_code'>$country_name</option>";
        }
        ?>
    </select>

    <label>State/County</label>
    <input type="text" name="state" placeholder="Enter your state or county">

    <label>Business Address</label>
    <input type="text" name="business_address" placeholder="Enter your business address">

    <label>Town/City</label>
    <input type="text" name="city" placeholder="Enter your town or city">

    <label>VAT Number *</label>
    <input type="text" name="vat_number" placeholder="Enter your VAT number" required>

    <label>Registration Number *</label>
    <input type="text" name="registration_number" placeholder="Enter your registration number" required>

    <label>Email Address *</label>
    <input type="email" name="email" placeholder="Enter your email address" required>

    <label>Phone Number *</label>
    <input type="text" name="phone" placeholder="Enter your phone number" required>

    <label>Password *</label>
    <input type="password" name="password" placeholder="Enter your password" required>

    <label>Confirm Password *</label>
    <input type="password" name="confirm_password" placeholder="Confirm your password" required>

    <input type="submit" name="wc_aff_register" value="Register">

    <!-- Display messages here -->
    <?php if (!empty($message)) : ?>
        <div class="form-message">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
</form>