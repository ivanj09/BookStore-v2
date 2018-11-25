'use strict';
module.exports = {
  up: (queryInterface, Sequelize) => {
    return queryInterface.createTable('Accounts', {
      card_number: {
        type: Sequelize.INTEGER,
        allowNull: false,
        autoIncrement: false,
        primaryKey: true,
      },
      name: {
        type: Sequelize.STRING
      },
      balance: {
        type: Sequelize.FLOAT
      },
      createdAt: {
        allowNull: false,
        type: Sequelize.DATE
      },
      updatedAt: {
        allowNull: false,
        type: Sequelize.DATE
      }
    })
    .then(() => queryInterface.addConstraint('Accounts', ['balance'], {
      type: 'check',
      where: {
        balance: {
          [Sequelize.Op.gte]: 0
        }
      }
    }));
  },
  down: (queryInterface, Sequelize) => {
    return queryInterface.dropTable('Accounts');
  }
};