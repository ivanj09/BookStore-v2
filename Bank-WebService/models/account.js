'use strict';
module.exports = (sequelize, DataTypes) => {
  var Account = sequelize.define('Account', {
    card_number: {
      type: DataTypes.INT,
      primaryKey: true
    },
    name: DataTypes.STRING,
    balance: DataTypes.FLOAT
  }, {});
  Account.associate = function(models) {
    // associations can be defined here
    Account.hasMany(models.Transaction, {
      foreignKey: 'sender_card',
      sourceKey: 'card_number'
    });

    Account.hasMany(models.Transaction, {
      foreignKey: 'receiver_card',
      sourceKey: 'card_number'
    });
  };
  return Account;
};