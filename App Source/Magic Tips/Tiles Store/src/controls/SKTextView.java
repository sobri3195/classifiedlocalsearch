package controls;

import android.content.Context;
import android.graphics.Typeface;
import android.util.AttributeSet;
import android.widget.TextView;

public class SKTextView extends TextView {

	public SKTextView(Context context,AttributeSet attrs, int defStyle) {
		super(context, attrs, defStyle);
        init();
		// TODO Auto-generated constructor stub
	}
	public SKTextView(Context context, AttributeSet attrs) {
        super(context, attrs);
        init();
    }

    public SKTextView(Context context) {
        super(context);
        init();
    }

    private void init() {
        Typeface tf = Typeface.createFromAsset(getContext().getAssets(),
                                               "MAGIC11.TTF");
        setTypeface(tf);
    }


}
