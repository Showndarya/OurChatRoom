/*create database Chat_Room;*/

create table if not exists users(
	id int not null auto_increament,
	first_name varchar(30) not null,
	last_name varchar(20),
	user_name varchar(30) unique,
	password varchar(50),
	join_time datetime,
	last_seen timestamp,
	primary key(id)
);

create table if not exists chats(
	id int not null auto_increament,
	creator int,
	is_group tinyint,
	create_time datetime,
	foreign key (creator) references users(id),
	primary key(id)
);

create table if not exists messages(
	id int not null auto_increament,
	chat_id int,
	sender_id int,
	time datetime,
	contents longtext,
	foreign key (chat_id) references chats(id),
	foreign key (sender) references users(id),
	primary key (id)
);

create table if not exists msg_details(
	msg_id int,
	rec_id int,
	time_rec datetime,
	time_read datetime,
	in_rec tinyint,
	foreign key (msg_id) references messages(id),
	foreign key (rec_id) references users(id),
	primary key (msg_id,rec_id)
);

create table if not exists chat_details(
	chat_id int,
	user_id int,
	name varchar(50),
	join_time datetime,
	foreign key (chat_id) references chats(id),
	foreign key (user_id) references users(id),
	primary key (user_id,chat_id)
);
