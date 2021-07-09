package dbHelper;


import defaultconfig.ConstValue;
import android.content.Context;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteException;
import android.database.sqlite.SQLiteDatabase.CursorFactory;
import android.database.sqlite.SQLiteOpenHelper;


public class SqlDbHelper extends SQLiteOpenHelper {
	public static SQLiteDatabase mDatabase;
	private boolean mIsInitializing = false;
	private final CursorFactory mFactory;
	public SqlDbHelper(Context context, String name, CursorFactory factory,
			int version) {
		super(context, name, factory, version);
		// TODO Auto-generated constructor stub
		mFactory = factory;
	}
	@Override
    public synchronized SQLiteDatabase getWritableDatabase() {
        if (mDatabase != null && mDatabase.isOpen() && !mDatabase.isReadOnly()) {
            return mDatabase;  // The database is already open for business
        }

        if (mIsInitializing) {
            throw new IllegalStateException("getWritableDatabase called recursively");
        }


        boolean success = false;
        SQLiteDatabase db = null;
        //if (mDatabase != null) mDatabase.lock();
        try {
            mIsInitializing = true;

            db = createOrOpenDatabase();


            onOpen(db);
            success = true;
            return db;
        } finally {
            mIsInitializing = false;
            if (success) {
                if (mDatabase != null) {
                    try { mDatabase.close(); } catch (Exception e) { }
                    //mDatabase.unlock();
                }
                mDatabase = db;
            } else {
                //if (mDatabase != null) mDatabase.unlock();
                if (db != null) db.close();
            }
        }

    }
	@Override
    public synchronized SQLiteDatabase getReadableDatabase() {
        if (mDatabase != null && mDatabase.isOpen()) {
        
            return mDatabase;  // The database is already open for business
        }

        if (mIsInitializing) {
            throw new IllegalStateException("getReadableDatabase called recursively");
        }

        try {
            return getWritableDatabase();
        } catch (SQLiteException e) {
           
        }

        SQLiteDatabase db = null;
        try {
            mIsInitializing = true;
           
            db = SQLiteDatabase.openDatabase(ConstValue.DATABASE_URL, mFactory, SQLiteDatabase.OPEN_READONLY);
            

            onOpen(db);
           
            mDatabase = db;
            return mDatabase;
        } finally {
            mIsInitializing = false;
            if (db != null && db != mDatabase) db.close();
        }
    }
	private SQLiteDatabase createOrOpenDatabase() {

        // test for the existence of the db file first and don't attempt open
        // to prevent the error trace in log on API 14+
        SQLiteDatabase db = null;
        db = SQLiteDatabase.openDatabase(ConstValue.DATABASE_URL, mFactory, SQLiteDatabase.OPEN_READWRITE);
        return db;
    }
	@Override
	public void onCreate(SQLiteDatabase db) {
		// TODO Auto-generated method stub
		
	}
	@Override
	public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
		// TODO Auto-generated method stub
		
	}


}
