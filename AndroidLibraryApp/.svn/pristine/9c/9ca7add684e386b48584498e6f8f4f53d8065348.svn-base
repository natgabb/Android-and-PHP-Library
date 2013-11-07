package cs534.team3.phase1.database;

import java.util.concurrent.ExecutionException;

import cs534.team3.phase1.Product;

import android.content.Context;
import android.database.Cursor;
import android.os.AsyncTask;
import android.util.Log;

/**
 * This class links the activities to the DBHelper via an AsyncTask.
 * 
 * @author Natacha Gabbamonte 0932340
 * @author Caroline Castonguay-Boisvert 084348
 * @author Gabriel Gheorghian 0737019
 * 
 *         Project CS534.team3.phase1
 * 
 */
public class AsyncDBHelper {

	private DBHelper database = null;
	private String tag = null;

	// Used to determine the kind of query by AsyncQuery
	private static final String GENRE = "GENRE";
	private static final String PLATFORM = "PLATFORM";
	private static final String NAME = "NAME";

	/**
	 * Constructor.
	 * 
	 * @param context
	 *            The context.
	 */
	public AsyncDBHelper(Context context, String tag) {
		database = new DBHelper(context, tag);
		this.tag = tag;
	}

	/**
	 * Returns all the products contained in the database.
	 * 
	 * @return the products
	 */
	public Cursor getAllProducts() {
		try {
			return new AsyncQuery().execute().get();
		} catch (InterruptedException e) {
			Log.e(tag, e.getClass() + " " + e.getMessage());
		} catch (ExecutionException e) {
			Log.e(tag, e.getClass() + " " + e.getMessage());
		}
		return null;
	}

	/**
	 * Returns all of the products corresponding to the genres.
	 * 
	 * @param genres
	 *            the genre filters
	 * @return the products that correspond to the genres
	 */
	public Cursor getProductsByGenre(String... genres) {
		try {
			return new AsyncQuery().execute(new String[] { GENRE }, genres)
					.get();
		} catch (InterruptedException e) {
			Log.e(tag, e.getClass() + " " + e.getMessage());
		} catch (ExecutionException e) {
			Log.e(tag, e.getClass() + " " + e.getMessage());
		}
		return null;
	}

	/**
	 * Returns all of the products corresponding to the platforms.
	 * 
	 * @param platforms
	 *            the platform filters
	 * @return the products that correspond to the platforms
	 */
	public Cursor getProductsByPlatform(String... platforms) {
		try {
			return new AsyncQuery().execute(new String[] { PLATFORM },
					platforms).get();
		} catch (InterruptedException e) {
			Log.e(tag, e.getClass() + " " + e.getMessage());
		} catch (ExecutionException e) {
			Log.e(tag, e.getClass() + " " + e.getMessage());
		}
		return null;
	}

	/**
	 * Gets a product based on the name
	 * 
	 * @param name
	 *            the name of the product
	 * @return the product
	 */
	public Cursor getProducts(String name) {
		try {
			return new AsyncQuery().execute(new String[] { NAME },
					new String[] { name }).get();
		} catch (InterruptedException e) {
			Log.e(tag, e.getClass() + " " + e.getMessage());
		} catch (ExecutionException e) {
			Log.e(tag, e.getClass() + " " + e.getMessage());
		}
		return null;
	}

	/**
	 * Gets a product based on the id
	 * 
	 * @param id
	 *            the id of the product
	 * @return the product
	 */
	public Product getProduct(int id) {
		try {
			return new AsyncQueryFromId().execute(id).get();
		} catch (InterruptedException e) {
			Log.e(tag, e.getClass() + " " + e.getMessage());
		} catch (ExecutionException e) {
			Log.e(tag, e.getClass() + " " + e.getMessage());
		}
		return null;
	}

	/**
	 * Inserts a new product into the database.
	 * 
	 * @param product
	 *            the product to insert
	 * @return the generated id, or -1 if there was an error, or -2 if an
	 *         exception occurred
	 */
	public long insertProduct(Product product) {
		try {
			return new AsyncInsert().execute(product).get();
		} catch (InterruptedException e) {
			Log.e(tag, e.getClass() + " " + e.getMessage());
		} catch (ExecutionException e) {
			Log.e(tag, e.getClass() + " " + e.getMessage());
		}
		return -2;
	}

	/**
	 * Deletes a product based on the id.
	 * 
	 * @param id
	 *            the id of the product to delete
	 * @return if the operation was successful or not
	 */
	public boolean deleteProduct(int id) {
		try {
			return new AsyncDelete().execute(id).get();
		} catch (InterruptedException e) {
			Log.e(tag, e.getClass() + " " + e.getMessage());
		} catch (ExecutionException e) {
			Log.e(tag, e.getClass() + " " + e.getMessage());
		}
		return false;
	}

	/**
	 * Updates a product based on the id of the product object.
	 * 
	 * @param product
	 *            the product to be updated
	 * @return if the operation was successful or not
	 */
	public boolean updateProduct(Product product) {
		try {
			return new AsyncUpdate().execute(product).get();
		} catch (InterruptedException e) {
			Log.e(tag, e.getClass() + " " + e.getMessage());
		} catch (ExecutionException e) {
			Log.e(tag, e.getClass() + " " + e.getMessage());
		}
		return false;
	}

	/*
	 * The AsyncTask for querying the products.
	 */
	private class AsyncQuery extends AsyncTask<String[], Void, Cursor> {

		@Override
		protected Cursor doInBackground(String[]... params) {
			if (params.length == 0)
				return database.getAllProducts();

			else if (params[0][0].equals(GENRE))
				return database.getProductsByGenres(params[1]);

			else if (params[0][0].equals(PLATFORM))
				return database.getProductsForPlatforms(params[1]);

			else if (params[0][0].equals(NAME))
				return database.getProducts(params[1][0]);

			else { // This should never happen
				Log.w(tag,
						"AsyncQuery in AsyncDBHelper: invalid params. Reached else.");
				return null;
			}
		}
	}

	/*
	 * The AsyncTask for querying the products from an ID number.
	 */
	private class AsyncQueryFromId extends AsyncTask<Integer, Void, Product> {
		@Override
		protected Product doInBackground(Integer... params) {
			return database.getProduct(params[0]);
		}
	}

	/*
	 * The AsyncTask for inserting a new product.
	 */
	private class AsyncInsert extends AsyncTask<Product, Void, Long> {
		@Override
		protected Long doInBackground(Product... params) {
			return database.insertProduct(params[0]);
		}
	}

	/*
	 * The AsyncTask for deleting a product.
	 */
	private class AsyncDelete extends AsyncTask<Integer, Void, Boolean> {
		@Override
		protected Boolean doInBackground(Integer... params) {
			return database.deleteProduct(params[0]);
		}
	}

	/*
	 * The AsyncTask for updating a product.
	 */
	private class AsyncUpdate extends AsyncTask<Product, Void, Boolean> {
		@Override
		protected Boolean doInBackground(Product... params) {
			return database.updateProduct(params[0]);
		}
	}
}
