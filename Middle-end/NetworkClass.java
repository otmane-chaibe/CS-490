package networkpackage;

import java.io.IOException;
import java.util.regex.*;

public class NetworkClass {
	public static int points;

	public static void main(String[] args) throws IOException {
		String output,methodName,qType,methodInput,methodOutput;
		int argNum,qDiff;
		qDiff = 0;
		methodName = "evenOdd";
		qType = "int";
		methodInput = "5";
		methodInput = "0";
		argNum = 1;
		
		///////////// POINTS
		if (qDiff == 0)
			points = 10;
		else if(qDiff == 1)
			points = 20;
		else
			points = 30;
		/////////////////////
		
		String text = "public static int evenOdd(int n){if (n%2==0) return 1; else return 0;}";
		//output = Integer.toString(evenOdd(6));
		/////////TESTS CALLS
		String qTypestr = "static\\s+"+qType+"\\s+";
		qTypeTest(qTypestr,text);
		String methodNamestr= methodName+"\\s*\\(";
		methodNameTest(methodNamestr,text);
		
		
		regex2("static\\s+?int\\s+[A-Za-z]+\\s*\\(",text);
		//System.out.print(output);
	}
	public static int evenOdd(int n){
		if (n%2==0)
			return 1;
		else 
			return 0;
	}
	public static void qTypeTest(String reg,String text){
		if (!regex(reg,text) ){
			points=points-1;
			System.out.println("Incorrect Method Type, so one points subtracted");
			System.out.println("New point count = "+points);
		}	
	}
	public static void methodNameTest(String reg,String text){
		if (!regex(reg,text) ){
			points=points-1;
			System.out.println("Incorrect Method Name, so one points subtracted");
			System.out.println("New point count = "+points);
		}	
	}
	
	public static boolean regex(String theRegex,String str){
		Pattern checkRegex = Pattern.compile(theRegex);
		Matcher regexMatcher = checkRegex.matcher(str);
		return regexMatcher.find();
		
	}
	public static void regex2(String theRegex, String str2Check){
		        Pattern checkRegex = Pattern.compile(theRegex);
		        Matcher regexMatcher = checkRegex.matcher( str2Check );
		        while ( regexMatcher.find() ){
		            if (regexMatcher.group().length() != 0){
		                System.out.println( regexMatcher.group().trim() );

		                System.out.println( "Start Index: " + regexMatcher.start());
		                System.out.println( "Start Index: " + regexMatcher.end());
		            }
		        }
		        System.out.println();
		    }

	
}
