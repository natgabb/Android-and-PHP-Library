package cs534.team3.phase1;

import cs534.team3.phase1.R;

import android.os.Bundle;
import android.os.Handler;
import android.app.Activity;
import android.content.Intent;
import android.content.SharedPreferences;

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
public class Splash extends Activity {

	public static final String SHARED_PREFS_TAG = "SHARED_PREFS_TAG";
	public static final String WANTS_SPLASH_TAG = "WANTS_SPLASH_TAG";
	public static final String USERNAME_TAG = "USERNAME_TAG";
	public static final String EMAIL_TAG = "EMAIL_TAG";

	/**
	 * Checks if the user wants the splash page to display. If yes, it creates
	 * it and displays it for 5 seconds, of not, it goes directly to the main
	 * page.
	 */
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		if (userWantsSplash()) {
			setContentView(R.layout.activity_splash);

			// Displays the main page after 5 seconds
			Handler handler = new Handler();
			Runnable newActivity = new Runnable() {
				public void run() {
					startNextActivityAndFinish();
				}
			};
			handler.postDelayed(newActivity, 5000);

		} else
			startNextActivityAndFinish();
	}

	/**
	 * Starts the Main activity.
	 */
	private void startNextActivityAndFinish() {
		startActivity(new Intent(this, Main.class));
		finish();
	}

	/**
	 * Gets the shared preferences and checks if the user wants a splash screen
	 * or not.
	 * 
	 * @return Whether the user wants a splash screen or not.
	 */
	private boolean userWantsSplash() {
		SharedPreferences prefs = getSharedPreferences(SHARED_PREFS_TAG,
				MODE_PRIVATE);
		return prefs.getBoolean(WANTS_SPLASH_TAG, true);
	}
}
