package cs534.team3.phase1;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.text.DecimalFormat;
import java.util.ArrayList;
import java.util.concurrent.ExecutionException;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import cs534.team3.phase1.database.AsyncDBHelper;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;
import android.widget.AdapterView.OnItemClickListener;

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
public class SearchResults extends Activity {

	public static final String TAG = "CGStudio";
	private ArrayList<Product> allProducts = null;

	private ListView listView;
	private Product product;
	private ArrayList<String> displayText;
	private AsyncDBHelper asyncDBHelper = null;

	private EditText quantity = null;
	private boolean isEmpty = false;

	/**
	 * Populates the view with the products retrieved with the query string.
	 */
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.search_display);

		// get products from json
		setJSON();
		listView = (ListView) findViewById(R.id.search_display_listview);

		addItemsToListView();
		setListListener();
	}

	/**
	 * Given the json, it creates the products and adds them to the allProducts
	 * array
	 */
	public void setJSON() {
		asyncDBHelper = Main.getAsyncDBHelper();
		Intent intent = this.getIntent();
		String json = "";
		allProducts = new ArrayList<Product>();

		try {
			json = new AsyncQuery().execute(intent.getStringExtra("query"))
					.get();

			if (json != null && json.length() > 2) {
				int start = json.indexOf('[');
				int end = json.lastIndexOf(']') + 1;

				if (start > 0 && end > start) {
					isEmpty = false;
					json = json.substring(start, end);

					JSONArray jObject = new JSONArray(json);

					for (int i = 0; i < jObject.length(); i++) {
						JSONObject menuObject = jObject.getJSONObject(i);
						Product product = new Product();

						// product.set_id(object.getInt(DBHelper.COLUMN_ID));
						product.setDate(menuObject.getString("CreateDate"));
						product.setDescription(menuObject
								.getString("Description"));
						product.setGenre(menuObject.getString("Genre"));

						product.setImageURL(menuObject.getString("Image"));
						product.setModifyDate(menuObject
								.getString("ModifyDate"));
						product.setName(menuObject.getString("Name"));
						product.setPhpId(menuObject.getInt("_id"));

						product.setPlatform(menuObject.getString("Platform"));
						product.setPrice(menuObject.getInt("Price"));
						product.setQuantity(menuObject.getInt("Quantity"));

						if (menuObject.getInt("Taxable") > 0) {
							product.setTaxable(true);
						} else {
							product.setTaxable(false);
						}
						allProducts.add(product);
					}
				} else {
					isEmpty = true;
				}
			} else {
				isEmpty = true;
			}

		} catch (InterruptedException e) {
			e.printStackTrace();
		} catch (ExecutionException e) {
			e.printStackTrace();
		} catch (JSONException e) {
			e.printStackTrace();
		}

	}

	/**
	 * Populates the listview with the product array from the search result.
	 */
	private void addItemsToListView() {
		displayText = new ArrayList<String>();
		if (isEmpty)
			displayText.add(getString(R.string.search_noproducts));
		else {
			// it goes through the whole array making text to add to the array
			// which
			// will display
			for (int i = 0; i < allProducts.size(); i++) {
				String text = getString(R.string.main_name_label) + " "
						+ allProducts.get(i).getName() + " "
						+ getString(R.string.main_quantity_label) + " "
						+ allProducts.get(i).getQuantity() + " "
						+ getString(R.string.main_platform_label) + " "
						+ allProducts.get(i).getPlatform() + " "
						+ getString(R.string.main_genre_label) + " "
						+ allProducts.get(i).getGenre();
				displayText.add(text);
			}
		}
		listView.setAdapter(new ArrayAdapter<String>(this,
				R.layout.centered_textview, displayText));
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
						View layout = inflater.inflate(R.layout.web_showupdate,
								null);

						// caching the textviews to display the product
						// information
						TextView theid = (TextView) layout
								.findViewById(R.id.web_id_display);
						quantity = (EditText) layout
								.findViewById(R.id.web_quantity_display);
						TextView price = (TextView) layout
								.findViewById(R.id.web_price_display);
						TextView genre = (TextView) layout
								.findViewById(R.id.web_genre_display);
						TextView platform = (TextView) layout
								.findViewById(R.id.web_platform_display);
						TextView description = (TextView) layout
								.findViewById(R.id.web_desc_display);
						TextView mdate = (TextView) layout
								.findViewById(R.id.web_mdate_display);

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
								SearchResults.this);
						builder.setView(layout);
						builder.setCancelable(false);
						builder.setTitle(product.getName());
						builder.setNegativeButton(
								getString(R.string.web_showupdate_add),
								new DialogInterface.OnClickListener() {
									public void onClick(DialogInterface dialog,
											int id) {
										// Add to the database.
										product.setQuantity(Integer
												.parseInt(quantity.getText()
														.toString()));
										if (asyncDBHelper
												.insertProduct(product) >= 0)
											// Everything went well
											Toast.makeText(
													SearchResults.this,
													getString(R.string.addUI_added),
													Toast.LENGTH_SHORT).show();
										else
											// Error occurred
											Toast.makeText(
													SearchResults.this,
													getString(R.string.search_error_message),
													Toast.LENGTH_SHORT).show();
										dialog.cancel();
									}
								}); // setNegButton()

						builder.setPositiveButton(
								getString(R.string.web_showupdate_cancel),
								new DialogInterface.OnClickListener() {
									public void onClick(DialogInterface dialog,
											int id) {
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
	 * Closes this activity.
	 * 
	 * @param v
	 *            the button
	 */
	public void onCancelButtonClick(View v) {
		finish();
	}

	/**
	 * The AsyncTask for retrieving the JSON.
	 */
	private class AsyncQuery extends AsyncTask<String, Void, String> {

		@Override
		protected String doInBackground(String... params) {
			String json = "";

			ConnectivityManager connMgr = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
			NetworkInfo networkInfo = connMgr.getActiveNetworkInfo();

			// Checks if the device is connected to the internet.
			if (networkInfo != null && networkInfo.isConnected()) {

				HttpURLConnection urlConn;
				try {
					// Gets the connection
					URL url = new URL(
							"http://waldo.dawsoncollege.qc.ca/0834048/html/CGStudio/remoteConnect.php"
									+ params[0]);
					urlConn = (HttpURLConnection) url.openConnection();
					urlConn.setRequestMethod("GET");
					urlConn.connect();
					Log.d(Main.TAG, "response: " + urlConn.getResponseCode());

					InputStream is = urlConn.getInputStream();
					BufferedReader reader = new BufferedReader(
							new InputStreamReader(is, "iso-8859-1"), 8);

					// Adds each line to the string.
					String line = null;
					while ((line = reader.readLine()) != null) {
						json += line + "\n";
					}
					is.close();

				} catch (IOException ioe) {
					Log.e(Main.TAG,
							"Exception caught while importing database:\n"
									+ ioe.getClass() + " " + ioe.getMessage());
				} catch (Exception e) {
					Log.e(Main.TAG, "Error converting results: " + e.toString());
				}
			}
			return json;
		}
	}
}
