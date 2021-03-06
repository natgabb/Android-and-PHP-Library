/**
 * 
 */
package cs534.team3.phase1;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.CheckBox;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.Spinner;

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
public class AddFromDatabase extends Activity {

	private Spinner platformsSpinner;
	private Spinner genresSpinner;
	private CheckBox modifyDateCheckBox;
	private DatePicker datePicker;
	private boolean dateChosen = false;

	/**
	 * Creates an instance of AddFromDatabase. Puts the query together to send
	 * to SearchResults.
	 */
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.add_search_ui);

		platformsSpinner = (Spinner) findViewById(R.id.add_search_ui_spinner_platform);
		genresSpinner = (Spinner) findViewById(R.id.add_search_ui_spinner_genre);
		modifyDateCheckBox = (CheckBox) findViewById(R.id.add_search_ui_checkbox_modify);
		datePicker = (DatePicker) findViewById(R.id.add_search_ui_datepicker);

		// Populating the platforms spinner.
		ArrayAdapter<CharSequence> platformsAdapter = ArrayAdapter
				.createFromResource(this, R.array.platforms_with_all,
						android.R.layout.simple_spinner_item);

		platformsAdapter
				.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);

		platformsSpinner.setAdapter(platformsAdapter);

		// Populating the genres spinner.
		ArrayAdapter<CharSequence> genresAdapter = ArrayAdapter
				.createFromResource(this, R.array.genres_with_all,
						android.R.layout.simple_spinner_item);

		genresAdapter
				.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);

		genresSpinner.setAdapter(genresAdapter);

		datePicker.setEnabled(false);
	}

	/**
	 * Starts the search activity, sending in the search options as extras.
	 * 
	 * @param v
	 *            the button
	 */
	public void onSearchButtonClick(View v) {
		Intent search = new Intent(this, SearchResults.class);

		boolean searchQuery = false;
		String query = "";

		// Adds the name if the person put one
		String name = ((EditText) findViewById(R.id.add_search_ui_editText_name))
				.getText().toString().trim();
		if (name.length() > 0) {
			query += "name=" + name.replace(" ", "%20");
			searchQuery = true;
		}

		// Adds the platform if something other than ALL was selected
		if (platformsSpinner.getSelectedItemPosition() != 0) {
			String platform = platformsSpinner.getSelectedItem().toString();
			if (searchQuery)
				query += "&";
			else
				searchQuery = true;
			query += "platform=" + platform;
		}

		// Adds the genre if something other than ALL was selected
		if (genresSpinner.getSelectedItemPosition() != 0) {
			String genre = genresSpinner.getSelectedItem().toString();
			if (searchQuery)
				query += "&";
			else
				searchQuery = true;
			query += "genre=" + genre;
		}

		// Adds the date if the person checked "Modify Date"
		if (dateChosen) {
			if (searchQuery)
				query += "&";
			else
				searchQuery = true;
			int year = datePicker.getYear();
			int month = datePicker.getMonth() + 1;
			int day = datePicker.getDayOfMonth();
			query += "date=" + year + "-" + month + "-" + day + "%2000:00:00";
		}

		// If there is a search query, adds ? + the query, otherwise sends an
		// empty String
		search.putExtra("query", searchQuery ? "?" + query : query);

		startActivity(search);
	}

	/**
	 * Starts the manual add item activity.
	 * 
	 * @param v
	 *            the button
	 */
	public void onManualButtonClick(View v) {
		startActivity(new Intent(this, AddItem.class));
	}

	/**
	 * Closes this activity.
	 * 
	 * @param v
	 *            the button
	 */
	public void onCancelButtonClick(View v) {
		finish();
	}

	/**
	 * If checked, will include the date in the search. If not, will not include
	 * it.
	 * 
	 * @param v
	 *            the checkbox
	 */
	public void onModifyCheckBoxClick(View v) {
		if (modifyDateCheckBox.isChecked()) {
			dateChosen = true;
			datePicker.setEnabled(true);
		} else {
			dateChosen = false;
			datePicker.setEnabled(false);
		}
	}
}
