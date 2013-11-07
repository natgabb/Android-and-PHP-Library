package cs534.team3.phase1;

import cs534.team3.phase1.R;
import cs534.team3.phase1.database.AsyncDBHelper;
import android.app.Activity;
import android.os.Bundle;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.Toast;

/**
 * Project Phase 2 : CS Studio
 * 
 * @author Caroline Castonguay-Boisvert 0834048
 * @author Gabriel Gheorghian 0737019
 * @author Natacha Gabbamonte 0932340
 * 
 *         Project CS534.team3.phase1
 * 
 */
public class AddItem extends Activity {

	private EditText nameEditText;
	private Spinner platformsSpinner;
	private Spinner genresSpinner;
	private EditText imageEditText;
	private EditText quantityEditText;
	private EditText descriptionEditText;
	private EditText priceEditText;
	private CheckBox taxableCheckBox;

	private AsyncDBHelper asyncDBHelper = null;

	/**
	 * Sets up the views, and permits the user to add a product to the database
	 * by manually entering the information.
	 */
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.addui);

		asyncDBHelper = Main.getAsyncDBHelper();

		// Store references to all the input fields.
		nameEditText = (EditText) findViewById(R.id.addUI_editText_name);
		platformsSpinner = (Spinner) findViewById(R.id.addui_spinner_platform);
		genresSpinner = (Spinner) findViewById(R.id.addui_spinner_genre);
		imageEditText = (EditText) findViewById(R.id.addUI_editText_image);
		quantityEditText = (EditText) findViewById(R.id.addUI_editText_quantity);
		descriptionEditText = (EditText) findViewById(R.id.addUI_editText_desc);
		priceEditText = (EditText) findViewById(R.id.addUI_editText_price);
		taxableCheckBox = (CheckBox) findViewById(R.id.addUI_checkBox_taxable);

		// Populating the platforms spinner.
		ArrayAdapter<CharSequence> platformsAdapter = ArrayAdapter
				.createFromResource(this, R.array.platforms,
						android.R.layout.simple_spinner_item);

		platformsAdapter
				.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);

		platformsSpinner.setAdapter(platformsAdapter);

		// Populating the genres spinner.
		ArrayAdapter<CharSequence> genresAdapter = ArrayAdapter
				.createFromResource(this, R.array.genres,
						android.R.layout.simple_spinner_item);

		genresAdapter
				.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);

		genresSpinner.setAdapter(genresAdapter);
	}

	/**
	 * Validates the fields in the form, and adds the product to the database if
	 * all values are valid.
	 * 
	 * @param v
	 */
	public void onAddButtonClick(View v) {
		// Text from the TextViews
		String name = nameEditText.getText().toString().trim();
		String platform = platformsSpinner.getSelectedItem().toString();
		String genre = genresSpinner.getSelectedItem().toString();
		String image = imageEditText.getText().toString().trim();
		String quantity = quantityEditText.getText().toString().trim();
		String description = descriptionEditText.getText().toString().trim();
		String price = priceEditText.getText().toString().trim();
		boolean taxable = taxableCheckBox.isChecked();

		// Checks that everything was filled
		String errorMessage = null;
		if (name.equals(""))
			errorMessage = getString(R.string.addUI_error_name);
		else if (image.equals(""))
			errorMessage = getString(R.string.addUI_error_url);
		else if (quantity.equals(""))
			errorMessage = getString(R.string.addUI_error_quantity);
		else if (!tryParseInt(quantity))
			errorMessage = getString(R.string.addUI_error_quantityValid);
		else if (description.equals(""))
			getString(R.string.addUI_error_desc);
		else if (price.equals(""))
			errorMessage = getString(R.string.addUI_error_price);
		else if (!tryParseDouble(price))
			errorMessage = getString(R.string.addUI_error_priceValid);
		else // Everything is valid
		{
			int quantityNum = Integer.parseInt(quantity);
			double priceNum = Double.parseDouble(price);

			Product product = new Product(-1, quantityNum, platform, genre,
					name, image, description,
					Math.round(priceNum * 100) / 100.0, taxable, "", "", -1);
			// Add to the database.
			asyncDBHelper.insertProduct(product);
			// Show message
			Toast.makeText(this, getString(R.string.addUI_added),
					Toast.LENGTH_SHORT).show();

			// Clear all fields.
			clearAllFields();
		}

		if (errorMessage != null)
			Toast.makeText(this, errorMessage, Toast.LENGTH_SHORT).show();
	}

	/**
	 * Closes this activity.
	 * 
	 * @param v
	 */
	public void onCancelButtonClick(View v) {
		finish();
	}

	/**
	 * Clears all the fields in the form.
	 */
	private void clearAllFields() {
		nameEditText.setText("");
		imageEditText.setText("");
		quantityEditText.setText("");
		descriptionEditText.setText("");
		priceEditText.setText("");

		platformsSpinner.setSelection(0);
		genresSpinner.setSelection(0);
		taxableCheckBox.setChecked(false);
	}

	/**
	 * Tests to see if a string is parsable into an int.
	 */
	private boolean tryParseInt(String num) {
		try {
			Integer.parseInt(num);
		} catch (NumberFormatException e) {
			return false;
		}
		return true;
	}

	/**
	 * Tests to see if a string is parsable into a double.
	 */
	private boolean tryParseDouble(String num) {
		try {
			Double.parseDouble(num);
		} catch (NumberFormatException e) {
			return false;
		}
		return true;
	}
}