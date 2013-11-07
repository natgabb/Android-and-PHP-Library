package cs534.team3.phase1;

import java.text.DecimalFormat;
import java.util.ArrayList;
import cs534.team3.phase1.database.AsyncDBHelper;
import cs534.team3.phase1.database.DBHelper;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ListView;
import android.widget.ArrayAdapter;
import android.widget.TextView;
import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.database.Cursor;

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
public class Main extends Activity {
	public static final String TAG = "CGStudio";
	public static final String DEBUG_TAG = "CGStudio Debug";

	private static AsyncDBHelper asyncDBHelper = null;

	private ListView listView;

	private ArrayList<Product> allProducts = null;
	private ArrayList<String> displayText = null;
	private Product product;

	/**
	 * Sets up the AsyncDBHelper and the ListView.
	 */
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.main);
		asyncDBHelper = new AsyncDBHelper(this, TAG);

		// caching the list
		listView = (ListView) findViewById(R.id.main_listView);

	}

	/**
	 * Adds the items to the ListView and sets up the listener for the onClick.
	 */
	@Override
	public void onResume() {
		super.onResume();
		addItemsToListView();
		setListListener();
	}

	/**
	 * Setting the listener with the popup
	 */
	public void setListListener() {

		if (allProducts.size() > 0) {
			listView.setOnItemClickListener(new OnItemClickListener() {

				// if an item is selected this will be called
				public void onItemClick(AdapterView<?> parent, View view,
						int position, long id) {
					// the product that was selected given the position in the
					// listview

					if (position >= 0 && position < allProducts.size()) {
						product = allProducts.get(position);

						LayoutInflater inflater = (LayoutInflater) getSystemService(LAYOUT_INFLATER_SERVICE);
						// Instantiate a layout XML file
						// into its corresponding View objectsfs
						View layout = inflater.inflate(
								R.layout.main_showupdate, null);

						// caching the textviews to display the product
						// information
						TextView theid = (TextView) layout
								.findViewById(R.id.show_id_display);
						TextView quantity = (TextView) layout
								.findViewById(R.id.show_quantity_display);
						TextView price = (TextView) layout
								.findViewById(R.id.show_price_display);
						TextView genre = (TextView) layout
								.findViewById(R.id.show_genre_display);
						TextView platform = (TextView) layout
								.findViewById(R.id.show_platform_display);
						TextView description = (TextView) layout
								.findViewById(R.id.show_desc_display);
						TextView mdate = (TextView) layout
								.findViewById(R.id.show_mdate_display);

						// formatting the price to display with 2 decimal places
						DecimalFormat df = new DecimalFormat("#.##");
						String formattedPrice = df.format(product.getPrice());

						// assigning product information to the right textview
						theid.setText(product.get_id() + "");
						quantity.setText(product.getQuantity() + "");
						price.setText(formattedPrice);
						genre.setText(product.getGenre());
						platform.setText(product.getPlatform());
						description.setText(product.getDescription());
						mdate.setText(product.getModifyDate());

						// create a new dialog builder context: current activity
						// class
						AlertDialog.Builder builder = new AlertDialog.Builder(
								Main.this);
						builder.setView(layout);
						builder.setCancelable(false);
						builder.setTitle(product.getName());
						builder.setNegativeButton(
								getString(R.string.costPreview_backButton),
								new DialogInterface.OnClickListener() {
									public void onClick(DialogInterface dialog,
											int id) {
										dialog.cancel();
									} 
								}); //setNegativeButton()
						builder.setPositiveButton(
								getString(R.string.costPreview_delete),
								new DialogInterface.OnClickListener() {
									public void onClick(DialogInterface dialog,
											int id) {
										asyncDBHelper.deleteProduct(product
												.get_id());
										addItemsToListView();
										dialog.cancel();
									} 
								}); // setPositiveButton()
						AlertDialog alertDialog = builder.create();

						alertDialog.show(); // show it
					}
				}
			});

		}
	}

	/**
	 * Adds all the items in the sqlite database to the list
	 */
	private void addItemsToListView() {
		Product product = null;
		allProducts = new ArrayList<Product>();
		displayText = new ArrayList<String>();

		Cursor cursor = asyncDBHelper.getAllProducts();
		if (cursor != null) {
			// Columns indexes
			int idIndex = cursor.getColumnIndex(DBHelper.COLUMN_ID);
			int quantityIndex = cursor.getColumnIndex(DBHelper.COLUMN_QUANTITY);
			int platformIndex = cursor.getColumnIndex(DBHelper.COLUMN_PLATFORM);
			int genreIndex = cursor.getColumnIndex(DBHelper.COLUMN_GENRE);
			int nameIndex = cursor.getColumnIndex(DBHelper.COLUMN_NAME);
			int imageURLIndex = cursor
					.getColumnIndex(DBHelper.COLUMN_IMAGE_URL);
			int descriptionIndex = cursor
					.getColumnIndex(DBHelper.COLUMN_DESCRIPTION);
			int priceIndex = cursor.getColumnIndex(DBHelper.COLUMN_PRICE);
			int taxableIndex = cursor.getColumnIndex(DBHelper.COLUMN_TAXABLE);
			int createdIndex = cursor.getColumnIndex(DBHelper.COLUMN_CREATED);
			int modifiedIndex = cursor.getColumnIndex(DBHelper.COLUMN_MODIFIED);
			
			// Adds each product to the arrays.
			while (cursor.moveToNext()) {
				product = new Product(cursor.getInt(idIndex),
						cursor.getInt(quantityIndex),
						cursor.getString(platformIndex),
						cursor.getString(genreIndex),
						cursor.getString(nameIndex),
						cursor.getString(imageURLIndex),
						cursor.getString(descriptionIndex),
						cursor.getDouble(priceIndex),
						cursor.getInt(taxableIndex) != 0,
						cursor.getString(createdIndex),
						cursor.getString(modifiedIndex), 0);
				
				// Sets the text to display
				String text = getString(R.string.main_name_label) + " "
						+ product.getName() + " "
						+ getString(R.string.main_quantity_label) + " "
						+ product.getQuantity() + " "
						+ getString(R.string.main_platform_label) + " "
						+ product.getPlatform() + " "
						+ getString(R.string.main_genre_label) + " "
						+ product.getGenre();
				allProducts.add(product);
				displayText.add(text);
			}
			if (displayText.isEmpty())
				displayText.add(getString(R.string.main_noproducts));
		}

		listView.setAdapter(new ArrayAdapter<String>(this,
				R.layout.centered_textview, displayText));
	}

	/**
	 * Returns the Asynchronous Database Helper.
	 * 
	 * @return The AsyncDBHelper Object.
	 */
	public static AsyncDBHelper getAsyncDBHelper() {
		return asyncDBHelper;
	}

	/**
	 * OnClickListener for the Cost Preview button.
	 * 
	 * @param v
	 *            the button
	 */
	public void startCostPreview(View v) {
		startActivity(new Intent(this, CostPreview.class));
	}

	/**
	 * OnClickListener for the Add Item button.
	 * 
	 * @param v
	 *            the button
	 */
	public void startAddItem(View v) {
		startActivity(new Intent(this, AddFromDatabase.class));
	}

	/**
	 * OnClickListener for the Set Preferences button.
	 * 
	 * @param v
	 *            the button
	 */
	public void startSetPrefs(View v) {
		startActivity(new Intent(this, SetPrefs.class));
	}
}