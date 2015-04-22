<?php

	/**
	 * DATA MANAGER
	 *
	 * Simple class to perform SQL statements on the OuweHaven database
	 */

	class DataManager {

		private $database;

		// SQL fields
		private $sql_select = array();
		private $sql_from = array();
		private $sql_where = array();
		private $sql_groupby = array();
		private $sql_having = array();
		private $sql_orderby = array();

		/**
		 * Initializes a new DataManager object
		 */
		public function __construct()
		{
			$database = new mysqli('clowting.me', 'ouwehaven', '8UcYeurzZ2qDLDYsFzaFNbY6', 'ouwehaven');

			if ($mysqli->connect_error) {
				throw new Exception("Kan geen verbinding maken met de database.");
			}
		}

		/**
		 * Adds a field to select, eventually with alias
		 */
		public function addSelectField($fieldName, $alias = '')
		{
			if(!empty($alias)) {
				$sql_select[] = $fieldName . ' AS ' . $alias;
			}
			else {
				$sql_select[] = $fieldName;
			}
		}

		/**
		 * Adds a table to the FROM clause
		 */
		public function addFromTable($tableName, $alias = '')
		{
			if(!empty($alias)) {
				$sql_from[] = $tableName . ' AS ' . $alias;
			}
			else {
				$sql_from[] = $tableName;
			}
		}

		/**
		 * Adds a statement to the WHERE clause
		 */
		public function addWhereStatement($statement, $and_or = '')
		{
			if(!empty($and_or)) {
				$sql_where[] = $statement . ' ' . $and_or;
			}
			else {
				$sql_where[] = $statement;
			}
		}

		/**
		 * Adds a GROUP BY field
		 */
		public function addGroupByField($fieldName)
		{
			$sql_groupby[] = $fieldName;
		}

		/**
		 * Adds a statement to the HAVING clause
		 */
		public function addHavingStatement($statement, $and_or = '')
		{
			if(!empty($and_or)) {
				$sql_having[] = $statement . ' ' . $and_or;
			}
			else {
				$sql_having[] = $statement;
			}
		}

		/**
		 * Adds a field to the ORDER BY clause
		 */
		public function addOrderByField($fieldName, $asc_desc = 'ASC')
		{
			$sql_orderby[] = $fieldName . ' ' . $asc_desc;
		}

	}