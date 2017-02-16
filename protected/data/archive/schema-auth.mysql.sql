/**
 * Database schema required by CDbAuthManager.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @since 1.0
 */

drop table if exists `auth_assignment`;
drop table if exists `auth_item_tree`;
drop table if exists `auth_item`;

create table `auth_item`
(
   `auth_item_name`                 varchar(64) not null,
   `auth_item_type`                 integer not null,
   `auth_item_description`          text,
   `auth_item_bizrule`              text,
   `auth_item_data`                 text,
   primary key (`auth_item_name`)
) engine InnoDB;

create table `auth_item_tree`
(
   `auth_item_tree_parent`               varchar(64) not null,
   `auth_item_tree_child`                varchar(64) not null,
   primary key (`auth_item_tree_parent`,`auth_item_tree_child`),
   foreign key (`auth_item_tree_parent`) references `auth_item` (`auth_item_name`) on delete cascade on update cascade,
   foreign key (`auth_item_tree_child`) references `auth_item` (`auth_item_name`) on delete cascade on update cascade
) engine InnoDB;

create table `auth_assignment`
(
   `auth_assignment_itemname`             varchar(64) not null,
   `auth_assignment_userid`               varchar(64) not null,
   `auth_assignment_bizrule`              text,
   `auth_assignment_data`                 text,
   primary key (`auth_assignment_itemname`,`auth_assignment_userid`),
   foreign key (`auth_assignment_itemname`) references `auth_item` (`auth_item_name`) on delete cascade on update cascade
) engine InnoDB;
