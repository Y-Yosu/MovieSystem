package database;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.Date;


public class Main {

	public static int nextUID = 5;

	public static void main(String[] args) throws Exception {

		//initiate table
		createTables();
		insertAll();
		
		/*
		qlogin1( "ms@gmail.com", "123" );
		qlogin1( "hellokb@gmail.com", "123" );
		qlogin1( "whodis@gmail.com", "123" );
		qregister1( Integer.toString(nextUID), "BayFake", "MrFake", "bfmrf@gmail.com", "124" );
		qlist1();
		qlist2("Title1", "Director1", null, null, null, null, null, Float.toString((float) 17.99));
		qrented1( "2" );
		qrented2( "1" );
		*/
		
		//delete all tables afterwards
		//dropAll();

	}
	
	public static void qlogin1( String req_user_mail, String req_user_password ) throws Exception{
		try {
			Connection con = getConnection();
			PreparedStatement qry = con.prepareStatement(" SELECT user_id from user where user_mail = '"+req_user_mail+"' and user_password = '"+req_user_password+"' ");
			ResultSet res = qry.executeQuery();
			while(res.next()) {
				System.out.println(res.getString("user_id"));
			}
		}catch(Exception e) {System.out.println(e);}
	}
	
	public static void qregister1( String user_id, String user_name, String user_surname, String user_mail, String user_password ) throws Exception{
		try {
			Connection con = getConnection();
			PreparedStatement qry = con.prepareStatement(" INSERT INTO user (user_id, user_name, user_surname, user_mail, user_password ) VALUES ( '"+user_id+"', '"+user_name+"', '"+user_surname+"', '"+user_mail+"', '"+user_password+"' ) ");
			qry.executeUpdate();
			nextUID++;
		}catch(Exception e) {System.out.println(e);}
	}
	
	public static void qlist1() throws Exception{
		try {
			Connection con = getConnection();
			PreparedStatement qry = con.prepareStatement("SELECT f_title, f_director, f_year, f_rating, f_genre, f_price FROM film ORDER BY f_id LIMIT 20;");
			ResultSet res = qry.executeQuery();
			while(res.next()) {
				System.out.print(res.getString("f_title"));
				System.out.print(" ");
				System.out.print(res.getString("f_director"));
				System.out.print(" ");
				System.out.print(res.getString("f_year"));
				System.out.print(" ");
				System.out.print(res.getString("f_rating"));
				System.out.print(" ");
				System.out.print(res.getString("f_genre"));
				System.out.print(" ");
				System.out.println(res.getString("f_price"));
			}
		}catch(Exception e) {System.out.println(e);}
	}
	
	public static void qlist2( String f_title, String f_director, String f_year, String f_genre, String minr, String maxr, String minp, String maxp ) throws Exception{
		try {
			Connection con = getConnection();
			if( f_title != null ) {
				f_title = "'" + f_title;
				f_title = f_title + "'";
			}
			if( f_director != null ) {
				f_director = "'" + f_director;
				f_director = f_director + "'";
			}
			if( f_year != null ) {
				f_year = "'" + f_year;
				f_year = f_year + "'";
			}
			if( f_genre != null ) {
				f_genre = "'" + f_genre;
				f_genre = f_genre + "'";
			}
			if( minr != null ) {
				minr = "'" + minr;
				minr = minr + "'";
			}
			if( maxr != null ) {
				maxr = "'" + maxr;
				maxr = maxr + "'";
			}
			if( minp != null ) {
				minp = "'" + minp;
				minp = minp + "'";
			}
			if( maxp != null ) {
				maxp = "'" + maxp;
				maxp = maxp + "'";
			}
			PreparedStatement qry = con.prepareStatement("SELECT f_title, f_director, f_year, f_rating, f_genre, f_price FROM film WHERE ( ("+f_title+" IS NULL) OR (f_title = "+f_title+") ) AND ( ("+f_director+" IS NULL) OR (f_director = "+f_director+") ) AND ( ("+f_year+" IS NULL) OR (f_year = "+f_year+") ) AND ( ("+f_genre+" IS NULL) OR (f_genre = "+f_genre+") ) AND ( ("+minr+" IS NULL) OR (f_rating > "+minr+") ) AND ( ("+maxr+" IS NULL) OR (f_rating < "+maxr+") ) AND ( ("+minp+" IS NULL) OR (f_price > "+minp+") ) AND ( ("+maxp+" IS NULL) OR (f_price < "+maxp+") ) ;" );
			ResultSet res = qry.executeQuery();
			while(res.next()) {
				System.out.print(res.getString("f_title"));
				System.out.print(" ");
				System.out.print(res.getString("f_director"));
				System.out.print(" ");
				System.out.print(res.getString("f_year"));
				System.out.print(" ");
				System.out.print(res.getString("f_rating"));
				System.out.print(" ");
				System.out.print(res.getString("f_genre"));
				System.out.print(" ");
				System.out.println(res.getString("f_price"));
			}
		}catch(Exception e) {System.out.println(e);}
	}

	public static void qrented1( String user_id ) throws Exception{
		try {
			Connection con = getConnection();
			PreparedStatement qry = con.prepareStatement("SELECT F.f_title, F.f_director, F.f_year, F.f_rating, F.f_genre, F.f_price FROM film as F, rent as R WHERE R.rent_status = \"Ongoing\" AND R.user_id = '"+user_id+"' AND R.f_id = F.f_id;");
			ResultSet res = qry.executeQuery();
			while(res.next()) {
				System.out.print(res.getString("F.f_title"));
				System.out.print(" ");
				System.out.print(res.getString("F.f_director"));
				System.out.print(" ");
				System.out.print(res.getString("F.f_year"));
				System.out.print(" ");
				System.out.print(res.getString("F.f_rating"));
				System.out.print(" ");
				System.out.print(res.getString("F.f_genre"));
				System.out.print(" ");
				System.out.println(res.getString("F.f_price"));
			}
		}catch(Exception e) {System.out.println(e);}
	}

	public static void qrented2( String user_id ) throws Exception{
		try {
			Connection con = getConnection();
			PreparedStatement qry = con.prepareStatement("SELECT F.f_title, F.f_director, F.f_year, F.f_rating, F.f_genre, F.f_price FROM film as F, rent as R WHERE R.rent_status = \"Expired\" AND R.user_id = '"+user_id+"' AND R.f_id = F.f_id;");
			ResultSet res = qry.executeQuery();
			while(res.next()) {
				System.out.print(res.getString("F.f_title"));
				System.out.print(" ");
				System.out.print(res.getString("F.f_director"));
				System.out.print(" ");
				System.out.print(res.getString("F.f_year"));
				System.out.print(" ");
				System.out.print(res.getString("F.f_rating"));
				System.out.print(" ");
				System.out.print(res.getString("F.f_genre"));
				System.out.print(" ");
				System.out.println(res.getString("F.f_price"));
			}
		}catch(Exception e) {System.out.println(e);}
	}
	
	
	public static void qtest( String test ) throws Exception{
		try {
			Connection con = getConnection();
			PreparedStatement qry = con.prepareStatement(" SELECT "+test+" IS NOT NULL");
			ResultSet res = qry.executeQuery();
			while(res.next()) {
				System.out.println(res.getString(""+test+" IS NOT NULL"));
			}
		}catch(Exception e) {System.out.println(e);}
	}
	
	public static void q3() throws Exception{
		try {
			Connection con = getConnection();
			PreparedStatement qry = con.prepareStatement("SELECT avg(M.count) as avg "
														+ "FROM( SELECT A.sid, count(A.cid) as count "
														+ "FROM apply as A GROUP BY A.sid) as M, student as S "
														+ "WHERE S.sid = M.sid GROUP BY S.nationality");
			ResultSet res = qry.executeQuery();
			while(res.next()) {
				System.out.println(res.getString("avg"));
			}
		}catch(Exception e) {System.out.println(e);}
	}
	
	public static void q4() throws Exception{
		try {
			Connection con = getConnection();
			PreparedStatement qry = con.prepareStatement(" SELECT C.cname "
					+ "FROM(  "
					+ "SELECT A.cid, count(A.sid) as count "
					+ "FROM apply as A, student as S "
					+ "WHERE S.year = \"freshman\" AND A.sid = S.sid "
					+ "GROUP BY A.cid) as Q1, "
					+ "( SELECT count(S.sid) as count "
					+ "FROM student as S "
					+ "WHERE S.year = \"freshman\") as Q2, company as C "
					+ "WHERE Q2.count = Q1.count AND C.cid = Q1.cid");
			ResultSet res = qry.executeQuery();
			while(res.next()) {
				System.out.println(res.getString("cname"));
			}
		}catch(Exception e) {System.out.println(e);}
	}
	
	public static void q5() throws Exception{
		try {
			Connection con = getConnection();
			PreparedStatement qry = con.prepareStatement("SELECT M.cid, avg(M.gpa) as avg"
					+ " FROM(  "
					+ "SELECT A.cid, S.gpa "
					+ "FROM apply as A, student as S "
					+ "WHERE A.sid = S.sid) as M "
					+ "GROUP BY M.cid");
			ResultSet res = qry.executeQuery();
			while(res.next()) {
				System.out.print(res.getString("cid"));
				System.out.print(": ");
				System.out.println(res.getString("avg"));
			}
		}catch(Exception e) {System.out.println(e);}
	}
		
	public static void insertAll() {
		
		try {
			//User init
		   addUser( "1", "Mary", "Sue", "ms@gmail.com", "123" );
		   addUser( "2", "Jane", "Doe", "jd@gmail.com", "123" );
		   addUser( "3", "Melih", "Ucer", "mu@gmail.com", "123" );
		   addUser( "4", "Kazim", "Bulut", "hellokb@gmail.com", "123" );
		   addUser( "5", "Oguzcan", "Pantalon", "kirbydoge@gmail.com", "123" );
		   addUser("6", "David", "Davenport", "divad@gmail.com", "123");
		   addUser("7", "Yasir", "Kizmaz", "myk@gmailcom", "123");
		   addUser("8", "Ozhan", "Ocal", "ocal@gmailcom", "123");
		   addUser("9", "Sarah", "Hassel", "shassel@gmailcom", "123");
		   addUser("10", "Alexander", "Degtrayev", "degrat@gmailcom", "123");
		   addUser("11", "Okan", "Tekman", "tekman@gmailcom", "123");
		   addUser("12", "yan", "shawn", "ytosh@gmailcom", "123");
		   addUser("13", "Sherwin", "Arashloo", "Sherwin@gmailcom", "123");
		   addUser("14", "Selim", "Aksoy", "saksoy@gmailcom", "123");
		   addUser("15", "Ali", "Yilmazer", "ulvi@gmailcom", "123");
		   addUser("16", "Paul", "Kimball", "kimball@gmailcom", "123");
		   addUser("17", "Tugce", "Ozturk", "tugce@gmailcom", "123");
		   addUser("18", "Ozcan", "Ozturk", "ozcanozturk@gmailcom", "123");
		   addUser("19", "Yaghhoub", "Heydarzade", "yakup@gmailcom", "123");
		   addUser("20", "Gokhan", "Keskin", "gokankeskin@gmailcom", "123");
		   addUser("21", "Norman", "Coker", "choker@gmailcom", "123");
		   addUser("22", "Ercument", "cCcek", "ecicek@gmailcom", "123");
		   addUser("23", "Ezhan", "Karashan", "ezhan@gmailcom", "123");
		   addUser("24", "Aynur", "Dayanik", "adayanik@gmailcom", "123");
		   addUser("25", "Eray", "Tuzun", "erayte@gmailcom", "123");
		   addUser("26", "Marlene", "Elwell", "marlin@gmailcom", "123");
		   addUser("27", "Mehmet", "Aktas", "fatih@gmailcom", "123");
		   addUser("28", "Ekmel", "Ozbay", "ekmel@gmailcom", "123");
		   addUser("29", "Billur", "Barshan", "billur@gmailcom", "123");
		   addUser("30", "Hamdi", "Dibeklioglu", "hamdi@gmailcom", "123");
		   addUser("31", "Emine", "Onculer", "emine@gmailcom", "123");
		   addUser("32", "Aykut", "Elmas", "CrazyBoy_AykutftCeza@gmailcom", "123");
		   addUser("33", "Cagri", "Durgut", "cagri@gmailcom", "123");
		   addUser("34", "Yusuf", "Uyar", "yosu@gmailcom", "123");
		   addUser("35", "Ali", "Aydogmus", "aea@gmailcom", "123");
		   addUser("36", "Seckin", "Satir", "seco@gmailcom", "123");
		   addUser("37", "James", "Hetfield", "frontman@gmailcom", "123");
		   addUser("38", "Lars", "Ulrich", "drummer@gmailcom", "123");
		   addUser("39", "Ron", "Mcgovney", "who@gmailcom", "123");
		   addUser("40", "Dave", "Mustaine", "badguy@gmailcom", "123");
		   addUser("41", "Cliff", "Burton", "thebassist@gmailcom", "123");
		   addUser("42", "Kirk", "Hammet", "lead@gmailcom", "123");
		   addUser("43", "Jason", "Newsted", "goat@gmailcom", "123");
		   addUser("44", "Robert", "Trulijo", "canavar@gmailcom", "123");
		   addUser("45", "Cetuk", "Cengizoglu", "cetuk@gmailcom", "123");
		   addUser("46", "Tolga", "Candar", "tolga@gmailcom", "123");
		   addUser("47", "Munir", "Selcuk", "nurettin@gmailcom", "123");
		   addUser("48", "Timur", "Selcuk", "tselcuk@gmailcom", "123");
		   addUser("49", "Muzeyyen", "Senar", "msenar@gmailcom", "123");
		   addUser("50", "Mehmet", "Erenler", "mehmeterenler@gmailcom", "123");
		   addUser("", "Son", "Sonoglu", "lastuser@gmail.com", "123");
			
		   
		   //PRE-MOCK DATA
		   
		   addCustomer( "1", 11, 11, 2011 );
			addCard( "1", (float) 100.99, "1234" );
			addHas( "1", "1" );
			addCustomer( "2", 5, 1, 1999 );
			addCard( "2", (float) 99.99, "1235" );
			addHas( "2", "2" );
			addCustomer( "3", 25, 10, 2000 );
			addCard( "3", (float) 37.99, "1236" );
			addHas( "3", "3" );
			addCustomer( "4", 07, 10, 2021 );
			addCard( "", (float) 45.99, "1236" );
			addHas( "4", "4" );
			addCustomer( "5", 25, 10, 1998 );
			addCard( "", (float) 3.14, "1236" );
			addHas( "5", "5" );
			
			addEmployee( "2", 1000 );
			addEmployee( "4", 1500 );
			addFriend( "1", "3", "Accepted" );
			addEmployee( "5", 9999 );
			addFriend( "4", "1", "Pending" );
			addFriend( "5", "1", "Pending" );
			addFriend( "1", "30", "Accepted" );
			addFriend( "1", "40", "Accepted" );
			//Movies init
			addFilm( "", "The Fellowship of the Ring", "Peter Jackson", "2001", (float) 0, "Adventure", (float) 17.99, "A meek Hobbit from the Shire and eight companions set out on a journey to destroy the powerful One Ring and save Middle-earth from the Dark Lord Sauron." );
			addFilm( "", "The Two Towers", "Peter Jackson", "2002", (float) 0, "Adventure", (float) 22.99, "While Frodo and Sam edge closer to Mordor with the help of the shifty Gollum, the divided fellowship makes a stand against Sauron''s new ally, Saruman, and his hordes of Isengard." );
			addFilm( "", "The Return of the King", "Peter Jackson", "2003", (float) 0, "Adventure", (float) 34.99, "Gandalf and Aragorn lead the World of Men against Sauron''s army to draw his gaze from Frodo and Sam as they approach Mount Doom with the One Ring." );
			addFilm( "", "Forrest Gump", "Robert Zemeckis", "1994", (float) 0, "Slice of Life", (float) 7.99, "The presidencies of Kennedy and Johnson, the Vietnam War, the Watergate scandal and other historical events unfold from the perspective of an Alabama man with an IQ of 75, whose only desire is to be reunited with his childhood sweetheart." );
			addFilm( "", "Inception", "Christopher Nolan", "2010", (float) 0, "Tension", (float) 13.99, "A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O., but his tragic past may doom the project and his team to disaster." );
			addFilm( "", "Fight Club", "David Fincher", "1999", (float) 0, "Psychological", (float) 21.99, "An insomniac office worker and a devil-may-care soap maker form an underground fight club that evolves into much more." );
			addFilm( "", "The Northman", "Robert Eggers", "2022", (float) 0, "Immersion", (float) 33.99, "From visionary director Robert Eggers comes The Northman, an action-filled epic that follows a young Viking prince on his quest to avenge his father''s murder." );
			addFilm( "", "The Lighthouse", "Robert Eggers", "2019", (float) 0, "Immersion", (float) 34.99, "Two lighthouse keepers try to maintain their sanity while living on a remote and mysterious New England island in the 1890s." );
			addFilm( "", "The Batman", "Matt Reeves", "2022", (float) 0, "Action", (float) 50.99, "When a sadistic serial killer begins murdering key political figures in Gotham, Batman is forced to investigate the city''s hidden corruption and question his family''s involvement." );
			addFilm( "", "Pulp Fiction", "Quentin Tarantino", "1994", (float) 0, "Tarantinoesque", (float) 30.29, "The lives of two mob hitmen, a boxer, a gangster and his wife, and a pair of diner bandits intertwine in four tales of violence and redemption." );
			addRent( "1", "1", 12, 11, 2011 );
			addReview( "1", "1", 12, 11, 2011, "Boring..." );
			addRating( "1", "1", 12, 11, 2011, (float) 2.0 );
			addRent( "1", "2", 18, 04, 2022 );
			addReview( "1", "2", 18, 04, 2022, "Fine, I guess..." );
			addRating( "1", "2", 18, 04, 2022, (float) 3.0 );
			addRent( "1", "3", 04, 05, 2022 );
			addReview( "1", "3", 04, 05, 2022, "Good." );
			addRating( "1", "3", 04, 05, 2022, (float) 3.5 );
			addRent( "1", "4", 16, 05, 2022 );
			addReview( "1", "4", 13, 11, 2011, "Very funny haha" );
			addRating( "1", "4", 13, 11, 2011, (float) 4.0 );
			addRent( "2", "4", 8, 4, 2022 );
			addSeries( "Lord of the Rings", "The Lord of the Rings is the saga of a group of sometimes reluctant heroes who set forth to save their world from consummate evil. Its many worlds and creatures were drawn from Tolkien''s extensive knowledge of philology and folklore." );
			addPartof( "1", "Lord of the Rings", Integer.toString(1) );
			addPartof( "2", "Lord of the Rings", Integer.toString(2) );
			addPartof( "3", "Lord of the Rings", Integer.toString(3) );
			
			//Absent init
			addAbsentFilm("1", "Absent1", "AbsentDir1", "2201", "Teenage Drama" );
			addRequest( "1", "1", "Pending", "I love this movie pls add");
			addAbsentFilm("2", "Absent2", "AbsentDir2", "2202", "Psychological" );
			addRequest( "2", "2", "Pending", "matematik!" );
			addReco( "1", "2", "4" );
			addReco( "3", "1", "2" );
			addReco( "3", "1", "1" );
			addReco( "4", "1", "1" );
			addReco( "2", "1", "3" );
		   
			for (int i = 6; i < 52; i++) {
                //System.out.println("Now working for " + i);
                int day;
                int month;
                int rnum = (int) (Math.random() * 61) + 1;
                if (rnum < 14){
                    day = rnum + 18;
                    month = 3;
                }
                else if (rnum < 44){
                    day = rnum - 13;
                    month = 4;
                }
                else {
                    day = rnum - 43;
                    month = 5;
                }
                addCustomer("" + i, day, month, 2022);
                addCard("" + i, (float) round(Math.random() * 100, 2), "Card of user with id: " + i);
                addHas("" + i, "" + i);
            }
            for (int i = 6; i < 50; i++) {
                addFriend("" + i, "" + (i + 1), "Accepted");
                addFriend("" + i, "" + (i + 2), "Accepted");
                addFriend("" + i, "" + (i - 3), "Pending");
            }
            for (int i = 6; i < 50; i++) {
            	int curfilm = ( ( (int) (Math.random() * 100) ) % 10 ) + 1;
            	int day;
                int month;
                int rnum = (int) (Math.random() * 30) + 1;
                if (rnum < 14){
                    day = rnum + 18;
                    month = 3;
                }
                else if (rnum < 44){
                    day = rnum - 13;
                    month = 4;
                }
                else {
                    day = rnum - 43;
                    month = 5;
                }
                System.out.println("user: " + i +" film: " + curfilm + " date: " + day + " " + month);
            	addRent("" + i, "" + curfilm, day, month, 2022 );
            	float ratingSS = (int) ( Math.random() * 10 + 1) / 2;
            	String reviewSS = "";
            	if( ratingSS >= 0 && ratingSS < 2 )
            		reviewSS += "Meh...";
            	else if( ratingSS >=2 && ratingSS < 3 )
            		reviewSS += "Mediocre";
            	else if( ratingSS >=3 && ratingSS < 4 )
            		reviewSS += "Good movie";
            	else
            		reviewSS += "Amazing film!";
            	addRating("" + i, "" + curfilm, day, month, 2022, ratingSS );
            	addReview("" + i, "" + curfilm, day, month, 2022, reviewSS );
            }
		   
			
		} catch(Exception e) {System.out.println(e);}
		finally { System.out.println("All values added."); };
		
		
		
	}
	
	public static double round(double value, int places) {
	    if (places < 0) throw new IllegalArgumentException();

	    long factor = (long) Math.pow(10, places);
	    value = value * factor;
	    long tmp = Math.round(value);
	    return (double) tmp / factor;
	}
	
	public static void dropAll() throws Exception{
		try {
			Connection conn = getConnection();
			conn.prepareStatement("DROP TABLE student").executeUpdate();
			conn.prepareStatement("DROP TABLE apply").executeUpdate();
			conn.prepareStatement("DROP TABLE company").executeUpdate();
			
		} catch(Exception e) {System.out.println(e);}
		finally { System.out.println("All tables deleted."); };
	} 
	
	public static void addUser( String user_id, String user_name, String user_surname, String user_mail, String user_password ) throws Exception{
		try {
			Connection conn = getConnection();
			PreparedStatement posted = conn.prepareStatement("INSERT INTO user ( user_name, user_surname, user_mail, user_password ) "
					+ " VALUES('"+user_name+"', '"+user_surname+"', '"+user_mail+"', '"+user_password+"' )");
			posted.executeUpdate();
			conn.close();
		} catch(Exception e) {System.out.println(e);}
	} 
	
	public static void addCustomer( String user_id, int day, int month, int year ) throws Exception{
		try {
			Connection conn = getConnection();
			java.util.Date d1 = new java.util.Date( year-1900, month-1, day );
			java.sql.Date d2 = new java.sql.Date(d1.getTime());
			PreparedStatement posted = conn.prepareStatement("INSERT INTO customer (user_id, join_date) "
					+ "VALUES('"+user_id+"', '"+d2+"' )");
			posted.executeUpdate();
			conn.close();
		} catch(Exception e) {System.out.println(e);}
	} 
	
	public static void addEmployee( String user_id, int salary ) throws Exception{
		try {
			Connection conn = getConnection();
			PreparedStatement posted = conn.prepareStatement("INSERT INTO employee (user_id, salary) "
					+ "VALUES('"+user_id+"', '"+salary+"' )");
			posted.executeUpdate();
			conn.close();
		} catch(Exception e) {System.out.println(e);}
	} 
	
	public static void addFilm( String f_id, String f_title, String f_director, String f_year, float f_rating, String f_genre, float f_price, String f_desc ) throws Exception{
		try {
			Connection conn = getConnection();
			PreparedStatement posted = conn.prepareStatement("INSERT INTO film ( f_title, f_director, f_year, f_rating, f_genre, f_price, f_desc) "
					+ "VALUES( '"+f_title+"', '"+f_director+"', '"+f_year+"', NULL, '"+f_genre+"', '"+f_price+"', '"+f_desc+"' )");
			posted.executeUpdate();
			conn.close();
		} catch(Exception e) {System.out.println(e);}
	} 
	
	public static void addAbsentFilm( String af_id, String af_title, String af_director, String af_year, String af_genre ) throws Exception{
		try {
			Connection conn = getConnection();
			PreparedStatement posted = conn.prepareStatement("INSERT INTO absent_film ( af_title, af_director, af_year, af_genre) "
					+ "VALUES( '"+af_title+"', '"+af_director+"', '"+af_year+"', '"+af_genre+"' )");
			posted.executeUpdate();
			conn.close();
		} catch(Exception e) {System.out.println(e);}
	} 
	
	public static void addCard( String card_id, float balance, String card_info ) throws Exception{
		try {
			Connection conn = getConnection();
			PreparedStatement posted = conn.prepareStatement("INSERT INTO card ( balance, card_info) "
					+ "VALUES('"+balance+"', '"+card_info+"' )");
			posted.executeUpdate();
			conn.close();
		} catch(Exception e) {System.out.println(e);}
	} 
	
	public static void addSeries( String series_name, String series_desc ) throws Exception{
		try {
			Connection conn = getConnection();
			PreparedStatement posted = conn.prepareStatement("INSERT INTO series ( series_name, series_desc ) "
					+ " VALUES('"+series_name+"', '"+series_desc+"' )");
			posted.executeUpdate();
			conn.close();
		} catch(Exception e) {System.out.println(e);}
	} 
	
	public static void addHas( String user_id, String card_id ) throws Exception{
		try {
			Connection conn = getConnection();
			PreparedStatement posted = conn.prepareStatement("INSERT INTO has (user_id, card_id) "
					+ "VALUES('"+user_id+"', '"+card_id+"' )");
			posted.executeUpdate();
			conn.close();
		} catch(Exception e) {System.out.println(e);}
	} 
	
	public static void addFriend( String adder_id, String added_id, String request_status ) throws Exception{
		try {
			Connection conn = getConnection();
			PreparedStatement posted = conn.prepareStatement("INSERT INTO add_friend (adder_id, added_id, request_status) "
					+ "VALUES('"+adder_id+"', '"+added_id+"', '"+request_status+"' )");
			posted.executeUpdate();
			conn.close();
		} catch(Exception e) {System.out.println(e);}
	} 
	
	public static void addRequest( String user_id, String af_id, String request_status, String request_desc ) throws Exception{
		try {
			Connection conn = getConnection();
			PreparedStatement posted = conn.prepareStatement("INSERT INTO request (user_id, af_id, request_status, request_desc) "
					+ "VALUES('"+user_id+"', '"+af_id+"', '"+request_status+"', '"+request_desc+"' )");
			posted.executeUpdate();
			conn.close();
		} catch(Exception e) {System.out.println(e);}
	} 
	
	public static void addReview( String user_id, String f_id, int day, int month, int year, String r_text ) throws Exception{
		try {
			Connection conn = getConnection();
			java.util.Date d1 = new java.util.Date( year-1900, month-1, day );
			java.sql.Date d2 = new java.sql.Date(d1.getTime());
			PreparedStatement posted = conn.prepareStatement("INSERT INTO review (user_id, f_id, r_date, r_text) "
					+ "VALUES('"+user_id+"', '"+f_id+"', '"+d2+"', '"+r_text+"' )");
			posted.executeUpdate();
			conn.close();
		} catch(Exception e) {System.out.println(e);}
	} 
	
	public static void addRating( String user_id, String f_id, int day, int month, int year, float r_rating ) throws Exception{
		try {
			Connection conn = getConnection();
			java.util.Date d1 = new java.util.Date( year-1900, month-1, day );
			java.sql.Date d2 = new java.sql.Date(d1.getTime());
			PreparedStatement posted = conn.prepareStatement("INSERT INTO rate (user_id, f_id, r_date, r_rating) "
					+ "VALUES('"+user_id+"', '"+f_id+"', '"+d2+"', '"+r_rating+"' )");
			posted.executeUpdate();
			conn.close();
		} catch(Exception e) {System.out.println(e);}
	} 
	
	public static void addReco( String recommender_id, String receiver_id, String f_id ) throws Exception{
		try {
			Connection conn = getConnection();
			PreparedStatement posted = conn.prepareStatement("INSERT INTO recommend (recommender_id, receiver_id, f_id) "
					+ "VALUES('"+recommender_id+"', '"+receiver_id+"', '"+f_id+"' )");
			posted.executeUpdate();
			conn.close();
		} catch(Exception e) {System.out.println(e);}
	} 
	
	public static void addRent( String user_id, String f_id, int day, int month, int year ) throws Exception{
		try {
			Connection conn = getConnection();
			java.util.Date d1 = new java.util.Date( year-1900, month-1, day );
			java.sql.Date d2 = new java.sql.Date(d1.getTime());
			PreparedStatement posted = conn.prepareStatement("INSERT INTO rent (user_id, f_id, rent_date ) "
					+ "VALUES('"+user_id+"', '"+f_id+"', '"+d2+"' )");
			posted.executeUpdate();
			conn.close();
		} catch(Exception e) {System.out.println(e);}
	} 
	
	public static void addPartof( String f_id, String series_name, String order_no ) throws Exception{
		try {
			Connection conn = getConnection();
			PreparedStatement posted = conn.prepareStatement("INSERT INTO part_of (f_id, series_name, order_no) "
					+ "VALUES('"+f_id+"', '"+series_name+"', '"+order_no+"' )");
			posted.executeUpdate();
			conn.close();
		} catch(Exception e) {System.out.println(e);}
	} 

	public static void createTables() throws Exception {
		try {
			Connection con = getConnection();

			con.prepareStatement("DROP TABLE IF EXISTS part_of").executeUpdate();
			con.prepareStatement("DROP TABLE IF EXISTS rent").executeUpdate();
			con.prepareStatement("DROP TABLE IF EXISTS recommend").executeUpdate();
			con.prepareStatement("DROP TABLE IF EXISTS rate").executeUpdate();
			con.prepareStatement("DROP TABLE IF EXISTS review").executeUpdate();
			con.prepareStatement("DROP TABLE IF EXISTS request").executeUpdate();
			con.prepareStatement("DROP TABLE IF EXISTS add_friend").executeUpdate();
			con.prepareStatement("DROP TABLE IF EXISTS has").executeUpdate();
			con.prepareStatement("DROP TABLE IF EXISTS series").executeUpdate();
			con.prepareStatement("DROP TABLE IF EXISTS card").executeUpdate();
			con.prepareStatement("DROP TABLE IF EXISTS absent_film").executeUpdate();
			con.prepareStatement("DROP TABLE IF EXISTS film").executeUpdate();
			con.prepareStatement("DROP TABLE IF EXISTS employee").executeUpdate();
			con.prepareStatement("DROP TABLE IF EXISTS customer").executeUpdate();
			con.prepareStatement("DROP TABLE IF EXISTS user").executeUpdate();
			
			//user
			con.prepareStatement("CREATE TABLE IF NOT EXISTS user(user_id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, user_name varchar(30), user_surname varchar(30), user_mail varchar(60), user_password varchar(30) )").executeUpdate();
			//customer
			con.prepareStatement("CREATE TABLE IF NOT EXISTS customer(user_id INT(11) NOT NULL PRIMARY KEY, join_date date, CONSTRAINT customer_pk FOREIGN KEY (user_id) REFERENCES user (user_id) ON DELETE CASCADE ON UPDATE CASCADE )").executeUpdate();
			//employee
			con.prepareStatement("CREATE TABLE IF NOT EXISTS employee(user_id INT(11) NOT NULL PRIMARY KEY, salary int, CONSTRAINT employee_pk FOREIGN KEY (user_id) REFERENCES user (user_id) ON DELETE CASCADE ON UPDATE CASCADE )").executeUpdate();
			//film
			con.prepareStatement("CREATE TABLE IF NOT EXISTS film(f_id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, f_title varchar(50), f_director varchar(60), f_year char(20), f_rating float(24), f_genre varchar(20), f_price float(24), f_desc varchar(350) )").executeUpdate();
			//absent_film
			con.prepareStatement("CREATE TABLE IF NOT EXISTS absent_film(af_id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, af_title varchar(50), af_director varchar(60), af_year char(20), af_genre varchar(20) )").executeUpdate();
			//card
			con.prepareStatement("CREATE TABLE IF NOT EXISTS card(card_id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, balance float(24), card_info char(60) )").executeUpdate();
			//series
			con.prepareStatement("CREATE TABLE IF NOT EXISTS series(series_name char(50) NOT NULL PRIMARY KEY, series_desc char(250) )").executeUpdate();
			//has
			con.prepareStatement("CREATE TABLE IF NOT EXISTS has(user_id INT(11) NOT NULL, card_id INT(11) NOT NULL, CONSTRAINT has_pk PRIMARY KEY (user_id, card_id), CONSTRAINT has_pk1 FOREIGN KEY (user_id) REFERENCES user (user_id) ON DELETE CASCADE ON UPDATE CASCADE, CONSTRAINT has_pk2 FOREIGN KEY (card_id) REFERENCES card (card_id) ON DELETE CASCADE ON UPDATE CASCADE )").executeUpdate();
			//add_friend
			con.prepareStatement("CREATE TABLE IF NOT EXISTS add_friend(adder_id INT(11) NOT NULL, added_id INT(11) NOT NULL, request_status varchar(20), CONSTRAINT add_friend_pk PRIMARY KEY (adder_id, added_id), CONSTRAINT add_friend_fk1 FOREIGN KEY (adder_id) REFERENCES user (user_id) ON DELETE CASCADE ON UPDATE CASCADE, CONSTRAINT add_friend_fk2 FOREIGN KEY (added_id) REFERENCES user (user_id) ON DELETE CASCADE ON UPDATE CASCADE )").executeUpdate();
			//request
			con.prepareStatement("CREATE TABLE IF NOT EXISTS request(user_id INT(11) NOT NULL, af_id INT(11) NOT NULL, request_status varchar(20), request_desc varchar(150), CONSTRAINT request_pk PRIMARY KEY (user_id, af_id), CONSTRAINT request_fk1 FOREIGN KEY (user_id) REFERENCES user (user_id) ON DELETE CASCADE ON UPDATE CASCADE, CONSTRAINT request_fk2 FOREIGN KEY (af_id) REFERENCES absent_film (af_id) ON DELETE CASCADE ON UPDATE CASCADE )").executeUpdate();
			//review
			con.prepareStatement("CREATE TABLE IF NOT EXISTS review(user_id INT(11) NOT NULL, f_id INT(11) NOT NULL, r_date date, r_text varchar(150), CONSTRAINT review_pk PRIMARY KEY (user_id, f_id), CONSTRAINT review_fk1 FOREIGN KEY (user_id) REFERENCES user (user_id) ON DELETE CASCADE ON UPDATE CASCADE, CONSTRAINT review_fk2 FOREIGN KEY (f_id) REFERENCES film (f_id) ON DELETE CASCADE ON UPDATE CASCADE )").executeUpdate();
			//rate
			con.prepareStatement("CREATE TABLE IF NOT EXISTS rate(user_id INT(11) NOT NULL, f_id INT(11) NOT NULL, r_date date, r_rating float(24), CONSTRAINT rate_pk PRIMARY KEY (user_id, f_id), CONSTRAINT rate_fk1 FOREIGN KEY (user_id) REFERENCES user (user_id) ON DELETE CASCADE ON UPDATE CASCADE, CONSTRAINT rate_fk2 FOREIGN KEY (f_id) REFERENCES film (f_id) ON DELETE CASCADE ON UPDATE CASCADE )").executeUpdate();
			//recommend
			con.prepareStatement("CREATE TABLE IF NOT EXISTS recommend(recommender_id INT(11) NOT NULL, receiver_id INT(11) NOT NULL, f_id INT(11) NOT NULL, CONSTRAINT recommend_pk PRIMARY KEY (recommender_id, receiver_id, f_id), CONSTRAINT recommend_fk1 FOREIGN KEY (recommender_id) REFERENCES user (user_id) ON DELETE CASCADE ON UPDATE CASCADE, CONSTRAINT recommend_fk2 FOREIGN KEY (receiver_id) REFERENCES user (user_id) ON DELETE CASCADE ON UPDATE CASCADE, CONSTRAINT recommend_fk3 FOREIGN KEY (f_id) REFERENCES film (f_id) ON DELETE CASCADE ON UPDATE CASCADE )").executeUpdate();
			//rent
			con.prepareStatement("CREATE TABLE IF NOT EXISTS rent(user_id INT(11) NOT NULL, f_id INT(11) NOT NULL, rent_date date, CONSTRAINT rent_pk PRIMARY KEY (user_id, f_id), CONSTRAINT rent_fk1 FOREIGN KEY (user_id) REFERENCES user (user_id) ON DELETE CASCADE ON UPDATE CASCADE, CONSTRAINT rent_fk2 FOREIGN KEY (f_id) REFERENCES film (f_id) ON DELETE CASCADE ON UPDATE CASCADE )").executeUpdate();
			//part_of
			con.prepareStatement("CREATE TABLE IF NOT EXISTS part_of(f_id INT(11) NOT NULL, series_name char(50) NOT NULL, order_no int, CONSTRAINT part_of_pk PRIMARY KEY (f_id, series_name), CONSTRAINT part_of_fk1 FOREIGN KEY (f_id) REFERENCES film (f_id) ON DELETE CASCADE ON UPDATE CASCADE, CONSTRAINT part_of_fk2 FOREIGN KEY (series_name) REFERENCES series (series_name) ON DELETE CASCADE ON UPDATE CASCADE )").executeUpdate();
			
			//rating trigger
			con.prepareStatement("CREATE TRIGGER film_rating1 AFTER INSERT ON rate FOR EACH ROW UPDATE film SET f_rating = ( SELECT avg(r_rating) FROM rate WHERE rate.f_id = film.f_id ) ").executeUpdate();
			con.prepareStatement("CREATE TRIGGER film_rating2 AFTER DELETE ON rate FOR EACH ROW UPDATE film SET f_rating = ( SELECT avg(r_rating) FROM rate WHERE rate.f_id = film.f_id ) ").executeUpdate();
			con.prepareStatement("CREATE TRIGGER film_rating3 AFTER UPDATE ON rate FOR EACH ROW UPDATE film SET f_rating = ( SELECT avg(r_rating) FROM rate WHERE rate.f_id = film.f_id ) ").executeUpdate();
			con.prepareStatement("CREATE TRIGGER film_rating4 AFTER DELETE ON user FOR EACH ROW UPDATE film SET f_rating = ( SELECT avg(r_rating) FROM rate WHERE rate.f_id = film.f_id ) ").executeUpdate();
			
			
		} catch (Exception e) {System.out.println(e);}
		finally { System.out.println("Tables created."); };
	}
	
	public static Connection getConnection() throws Exception{
		try {
			String driver = "com.mysql.cj.jdbc.Driver";
			String url = "jdbc:mysql://dijkstra.ug.bcc.bilkent.edu.tr/emre_aydogmus";
			String username = "emre.aydogmus";
			String password = "nENFEPaH";
			Class.forName( driver );
			Connection conn = DriverManager.getConnection(url, username, password);
			//System.out.println("Connected");
			return conn;
		} catch(Exception e) {System.out.println(e);}
		
		return null;
	}
}
