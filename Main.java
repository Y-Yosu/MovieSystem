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
			addCustomer( "1", 11, 11, 2011 );
			addCard( "1", (float) 80.99, "1234" );
			addHas( "1", "1" );
			addCustomer( "2", 5, 1, 1999 );
			addCard( "2", (float) 99.99, "1235" );
			addHas( "2", "2" );
			addCustomer( "3", 25, 10, 2000 );
			addCard( "3", (float) 37.99, "1236" );
			addHas( "3", "3" );
			addEmployee( "2", 1000 );
			addEmployee( "4", 1500 );
			addFriend( "1", "3", "Accepted" );
			addFriend( "1", "2", "Pending" );
			addCustomer( "5", 25, 10, 1998 );
			addEmployee( "5", 9999 );
			addFriend( "4", "1", "Pending" );
			addFriend( "5", "1", "Pending" );
			//Movies init
			addFilm( "1", "Title1", "Director1", "2001", (float) 3.1, "Horror", (float) 17.99, "First Movie" );
			addFilm( "2", "Title2", "Director2", "2002", (float) 3.1, "Action", (float) 22.99, "2nd Movie" );
			addFilm( "3", "Title3", "Director3", "2003", (float) 3.1, "Drama", (float) 34.99, "3rd Movie" );
			addFilm( "4", "Title4", "Director4", "2004", (float) 3.1, "Comedy", (float) 7.99, "4th Movie" );
			addRent( "1", "1", 12, 11, 2011 );
			addReview( "1", "1", 12, 11, 2011, "Boring..." );
			addRating( "1", "1", 12, 11, 2011, (float) 2.0 );
			addRent( "1", "4", 16, 05, 2022 );
			addReview( "1", "4", 13, 11, 2011, "Very funny haha" );
			addRating( "1", "4", 13, 11, 2011, (float) 4.0 );
			addRent( "2", "4", 8, 4, 2022 );
			addSeries( "Series1", "First series of the website" );
			addPartof( "1", "Series1", Integer.toString(4) );
			addPartof( "2", "Series1", Integer.toString(2) );
			addPartof( "3", "Series1", Integer.toString(1) );
			addPartof( "4", "Series1", Integer.toString(3) );
			
			//Absent init
			addAbsentFilm("1", "Absent1", "AbsentDir1", "2201", "Teenage Drama" );
			addRequest( "1", "1", "Pending", "I love this movie pls add");
			addAbsentFilm("2", "Absent2", "AbsentDir2", "2202", "Psychological" );
			addRequest( "2", "2", "Pending", "matematik!" );
			addReco( "1", "2", "4" );
			addReco( "3", "1", "2" );
			
		} catch(Exception e) {System.out.println(e);}
		finally { System.out.println("All values added."); };
		
		
		
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
		} catch(Exception e) {System.out.println(e);}
	} 
	
	public static void addEmployee( String user_id, int salary ) throws Exception{
		try {
			Connection conn = getConnection();
			PreparedStatement posted = conn.prepareStatement("INSERT INTO employee (user_id, salary) "
					+ "VALUES('"+user_id+"', '"+salary+"' )");
			posted.executeUpdate();
		} catch(Exception e) {System.out.println(e);}
	} 
	
	public static void addFilm( String f_id, String f_title, String f_director, String f_year, float f_rating, String f_genre, float f_price, String f_desc ) throws Exception{
		try {
			Connection conn = getConnection();
			PreparedStatement posted = conn.prepareStatement("INSERT INTO film (f_id, f_title, f_director, f_year, f_rating, f_genre, f_price, f_desc) "
					+ "VALUES('"+f_id+"', '"+f_title+"', '"+f_director+"', '"+f_year+"', NULL, '"+f_genre+"', '"+f_price+"', '"+f_desc+"' )");
			posted.executeUpdate();
		} catch(Exception e) {System.out.println(e);}
	} 
	
	public static void addAbsentFilm( String af_id, String af_title, String af_director, String af_year, String af_genre ) throws Exception{
		try {
			Connection conn = getConnection();
			PreparedStatement posted = conn.prepareStatement("INSERT INTO absent_film ( af_title, af_director, af_year, af_genre) "
					+ "VALUES( '"+af_title+"', '"+af_director+"', '"+af_year+"', '"+af_genre+"' )");
			posted.executeUpdate();
		} catch(Exception e) {System.out.println(e);}
	} 
	
	public static void addCard( String card_id, float balance, String card_info ) throws Exception{
		try {
			Connection conn = getConnection();
			PreparedStatement posted = conn.prepareStatement("INSERT INTO card ( balance, card_info) "
					+ "VALUES('"+balance+"', '"+card_info+"' )");
			posted.executeUpdate();
		} catch(Exception e) {System.out.println(e);}
	} 
	
	public static void addSeries( String series_name, String series_desc ) throws Exception{
		try {
			Connection conn = getConnection();
			PreparedStatement posted = conn.prepareStatement("INSERT INTO series ( series_name, series_desc ) "
					+ " VALUES('"+series_name+"', '"+series_desc+"' )");
			posted.executeUpdate();
		} catch(Exception e) {System.out.println(e);}
	} 
	
	public static void addHas( String user_id, String card_id ) throws Exception{
		try {
			Connection conn = getConnection();
			PreparedStatement posted = conn.prepareStatement("INSERT INTO has (user_id, card_id) "
					+ "VALUES('"+user_id+"', '"+card_id+"' )");
			posted.executeUpdate();
		} catch(Exception e) {System.out.println(e);}
	} 
	
	public static void addFriend( String adder_id, String added_id, String request_status ) throws Exception{
		try {
			Connection conn = getConnection();
			PreparedStatement posted = conn.prepareStatement("INSERT INTO add_friend (adder_id, added_id, request_status) "
					+ "VALUES('"+adder_id+"', '"+added_id+"', '"+request_status+"' )");
			posted.executeUpdate();
		} catch(Exception e) {System.out.println(e);}
	} 
	
	public static void addRequest( String user_id, String af_id, String request_status, String request_desc ) throws Exception{
		try {
			Connection conn = getConnection();
			PreparedStatement posted = conn.prepareStatement("INSERT INTO request (user_id, af_id, request_status, request_desc) "
					+ "VALUES('"+user_id+"', '"+af_id+"', '"+request_status+"', '"+request_desc+"' )");
			posted.executeUpdate();
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
		} catch(Exception e) {System.out.println(e);}
	} 
	
	public static void addReco( String recommender_id, String receiver_id, String f_id ) throws Exception{
		try {
			Connection conn = getConnection();
			PreparedStatement posted = conn.prepareStatement("INSERT INTO recommend (recommender_id, receiver_id, f_id) "
					+ "VALUES('"+recommender_id+"', '"+receiver_id+"', '"+f_id+"' )");
			posted.executeUpdate();
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
		} catch(Exception e) {System.out.println(e);}
	} 
	
	public static void addPartof( String f_id, String series_name, String order_no ) throws Exception{
		try {
			Connection conn = getConnection();
			PreparedStatement posted = conn.prepareStatement("INSERT INTO part_of (f_id, series_name, order_no) "
					+ "VALUES('"+f_id+"', '"+series_name+"', '"+order_no+"' )");
			posted.executeUpdate();
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
			con.prepareStatement("CREATE TABLE IF NOT EXISTS film(f_id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, f_title varchar(50), f_director varchar(60), f_year char(20), f_rating float(24), f_genre varchar(20), f_price float(24), f_desc varchar(150) )").executeUpdate();
			//absent_film
			con.prepareStatement("CREATE TABLE IF NOT EXISTS absent_film(af_id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, af_title varchar(50), af_director varchar(60), af_year char(20), af_genre varchar(20) )").executeUpdate();
			//card
			con.prepareStatement("CREATE TABLE IF NOT EXISTS card(card_id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, balance float(24), card_info char(60) )").executeUpdate();
			//series
			con.prepareStatement("CREATE TABLE IF NOT EXISTS series(series_name char(50) NOT NULL PRIMARY KEY, series_desc char(150) )").executeUpdate();
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
