package cs534.team3.phase1;

import java.text.DecimalFormat;
import java.util.ArrayList;

import cs534.team3.phase1.R;
import cs534.team3.phase1.database.AsyncDBHelper;
import cs534.team3.phase1.database.DBHelper;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.database.Cursor;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.AdapterView.OnItemClickListener;

/**
 * Project Phase 2 : CS Studio
 * 
 * @author Caroline Castonguay-Boisvert 0834048
 * @author Gabriel Gheorgian 0737019
 * @author Natacha Gabbamonte 0932340
 * 
 *         Project CS534.team3.phase1
 * 
 */
public class CostPreview extends Activity {

	private static double GST_TAX = 0.05;
	private static double TVQ_TAX = 0.095;

	private AsyncDBHelper asyncDBHelper = null;
	private ArrayList<Product> allProducts = null;
	private ArrayList<String> displayText = null;
	private ListView listView = null;
	private DecimalFormat moneyFormat;

	private Product product;

	/**
	 * Sets up the views and shows the products with the cost.
	 */
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);

		setContentView(R.layout.cost_preview);

		moneyFormat = new DecimalFormat("$#,##0.00");
		listView = (ListView) findViewById(R.id.costPreview_listView);
		asyncDBHelper = Main.getAsyncDBHelper();
		addItemsToListView();
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
	 * Sets the listener with the popup.
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
								CostPreview.this);
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
								}); // setNegButton()
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
								});  // setPositiveButton()
						AlertDialog alertDialog = builder.create();

						alertDialog.show(); // show it
					}
				}
			});

		}
	}

	/**
	 * Adds the items to the ListView.
	 */
	private void addItemsToListView() {
		allProducts = new ArrayList<Product>();
		displayText = new ArrayList<String>();

		Cursor cursor = asyncDBHelper.getAllProducts();
		Product product = null;
		String text = null;

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

				allProducts.add(product);
				double price = product.getPrice();
				
				// Sets the text to display
				text = "[" + product.getName() + "]" + " "
						+ getString(R.string.costPreview_price) + " "
						+ moneyFormat.format(price);

				// Adds the taxes to the price if the product is taxable.
				if (product.isTaxable()) {
					double gst = Math.round(calculateGST(price) * 100) / 100.0;
					double tvq = Math.round(calculateTVQ(price + gst) * 100) / 100.0;
					double total = Math.round((price + gst + tvq) * 100) / 100.0;
					text = text + " " + getString(R.string.costPreview_gst)
							+ " " + moneyFormat.format(gst) + " "
							+ getString(R.string.costPreview_tvq) + " "
							+ moneyFormat.format(tvq) + " "
							+ getString(R.string.costPreview_total) + " "
							+ moneyFormat.format(total);
				}
				displayText.add(text);
			}
		} else
			Log.w(Main.TAG, "Cursor in CostPreview is null.");

		listView.setAdapter(new ArrayAdapter<String>(this,
				R.layout.centered_textview, displayText));
	}

	/**
	 * Closes this activity.
	 * 
	 * @param v
	 *            the button
	 */
	public void onOKClick(View v) {
		finish();
	}

	/**
	 * Calculates the GST
	 * 
	 * @param price
	 *            the price of the item
	 * @return the GST tax
	 */
	private double calculateGST(double price) {
		return price * GST_TAX;
	}

	/**
	 * Calculates the TVQ
	 * 
	 * @param price
	 *            the price of the item
	 * @return the TVQ tax
	 */
	private double calculateTVQ(double price) {
		return price * TVQ_TAX;
	}

}
