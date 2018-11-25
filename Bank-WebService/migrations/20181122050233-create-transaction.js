'use strict';
module.exports = {
  up: (queryInterface, Sequelize) => {
    return queryInterface.createTable('Transactions', {
      id: {
        allowNull: false,
        autoIncrement: true,
        primaryKey: true,
        type: Sequelize.INTEGER
      },
      sender_card: {
        type: Sequelize.INTEGER,
        references: {
          model: 'Accounts',
          key: 'card_number'
        }
      },
      receiver_card: {
        type: Sequelize.INTEGER,
        references: {
          model: 'Accounts',
          key: 'card_number'
        }
      },
      amount: {
        type: Sequelize.FLOAT
      },
      transaction_time: {
        type: Sequelize.DATE
      },
      createdAt: {
        allowNull: false,
        type: Sequelize.DATE
      },
      updatedAt: {
        allowNull: false,
        type: Sequelize.DATE
      }
    });
  },
  down: (queryInterface, Sequelize) => {
    return queryInterface.dropTable('Transactions');
  }
};